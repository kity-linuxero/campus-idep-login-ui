#!/bin/bash
# Despliega el tema theme_idep y los assets de /branding/ en el contenedor del
# Moodle (Proxmox LXC). Se corre en el host Proxmox, desde la raíz del repo:
#
#   ./moodle/deploy.sh            # CT 606 por defecto
#   CTID=606 ./moodle/deploy.sh
#
# Además de copiar archivos, reinicia PHP-FPM y borra la caché de CSS
# compilado: sin eso Moodle sigue sirviendo el CSS viejo aunque el archivo
# haya cambiado (ver moodle/README.md, "Trampas conocidas").
set -euo pipefail

CTID="${CTID:-606}"
MOODLE="/var/www/moodle"
BRANDING="/var/www/branding"
REPO="$(cd "$(dirname "$0")/.." && pwd)"

echo "==> Tema theme_idep -> CT $CTID:$MOODLE/public/theme/idep"
tar -C "$REPO/moodle" -cf - theme_idep | pct exec "$CTID" -- bash -c "
set -e
rm -rf /tmp/idepdeploy && mkdir -p /tmp/idepdeploy && tar -C /tmp/idepdeploy -xf -
rm -rf $MOODLE/public/theme/idep
mv /tmp/idepdeploy/theme_idep $MOODLE/public/theme/idep && rmdir /tmp/idepdeploy
chown -R root:www-data $MOODLE/public/theme/idep
find $MOODLE/public/theme/idep -type d -exec chmod 750 {} +
find $MOODLE/public/theme/idep -type f -exec chmod 640 {} +
"

echo "==> Assets -> CT $CTID:$BRANDING"
tar -C "$REPO" -cf - images/campusLogoSolo.png images/campusLogoCompleto.png images/fondocampus.png images/institutos-fila.png \
    -C "$REPO/moodle/branding" fonts | pct exec "$CTID" -- bash -c "
set -e
rm -rf /tmp/brandingdeploy && mkdir -p /tmp/brandingdeploy && tar -C /tmp/brandingdeploy -xf -
mkdir -p $BRANDING/fonts
cp /tmp/brandingdeploy/images/*.png $BRANDING/
cp /tmp/brandingdeploy/fonts/*.woff2 $BRANDING/fonts/
rm -rf /tmp/brandingdeploy
chown -R www-data:www-data $BRANDING
"

echo "==> Upgrade (registra cambios de version.php) y limpieza de cachés"
pct exec "$CTID" -- bash -c "
set -e
systemctl restart php8.4-fpm
rm -rf /var/www/moodledata/cache/cachestore_file/default_application/core_postprocessedcss \
       /var/www/moodledata/localcache/theme/*/idep /var/www/moodledata/temp/theme/idep
cd $MOODLE
runuser -u www-data -- php admin/cli/upgrade.php --non-interactive | tail -1
runuser -u www-data -- php admin/cli/purge_caches.php
"
echo "==> Listo. Probá con un hard refresh (Ctrl+Shift+R) en /login/index.php"
