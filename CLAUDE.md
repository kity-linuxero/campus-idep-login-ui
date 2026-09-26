# Campus IDEP — Login UI

Login del Campus Virtual IDEP (Moodle 5.2). Dos piezas que tienen que mantenerse en sintonía:

- `index.html`: maqueta estática (HTML + un solo `<style>`, sin frameworks ni build). Es la referencia visual.
- `moodle/theme_idep/`: tema hijo de Boost que implementa ese login en el campus real. Es lo que está en producción.
  Leé `moodle/README.md` antes de tocarlo (mapeo de clases maqueta → tema y trampas conocidas).

## Reglas de diseño

- El sistema de diseño está en `.superdesign/design-system.md` y es una restricción, no una sugerencia: solo verde IDEP (`#00792f` y sus tonos), negro, blanco y grises neutros; solo Barlow y Barlow Condensed.
- El logo (`images/campusLogoSolo.png`) va siempre sobre blanco. La fila de institutos es negra: sobre fondo oscuro se usa con `filter: invert(1)`. Nunca reemplazar el logo por texto, iniciales o un SVG inventado.
- Prohibido en la pantalla: selector de idioma, aviso de cookies, estadísticas genéricas, acceso de invitados, login social.

## Flujo para un cambio en el login

1. Cambiar `index.html` y regenerar las capturas del README (solo si cambia algo visual):

   ```bash
   google-chrome --headless=new --hide-scrollbars --window-size=1440,900 --virtual-time-budget=5000 --screenshot=docs/screenshots/desktop.png "file://$PWD/index.html"
   google-chrome --headless=new --hide-scrollbars --force-device-scale-factor=2 --window-size=390,1000 --virtual-time-budget=5000 --screenshot=docs/screenshots/mobile.png "file://$PWD/index.html"
   ```

2. Portar el cambio a `moodle/theme_idep`:
   - estructura → `templates/login.mustache` (página) o `templates/core/loginform.mustache` (formulario);
   - estilos → `lib.php` (`theme_idep_get_extra_scss`), siempre bajo `body.idep-login-page` y con clases `idep-`; nunca selectores sueltos (`h1`, `label`, `input`) porque pisan o son pisados por Boost;
   - textos → `lang/es/theme_idep.php` y el mismo identificador en `lang/en/theme_idep.php`;
   - el formulario tiene que conservar lo funcional del core: `logintoken`, `name="username"`/`"password"`, `id="loginbtn"`, alertas de error/mantenimiento y recaptcha.
3. Subir `$plugin->version` en `moodle/theme_idep/version.php`.
4. Desplegar desde el host Proxmox con `./moodle/deploy.sh` (reinicia PHP-FPM y limpia la caché de CSS; sin eso Moodle sirve CSS viejo).
5. Verificar según `moodle/README.md` (desktop, mobile, login fallido, "¿Olvidó su contraseña?", engranaje del tema).

Para iterar el diseño con Superdesign, usar la skill en `.claude/skills/superdesign/` y los IDs de proyecto/draft de `prompts/superdesign-login.md`.

El banner de campaña (imagen, enlace, fecha de fin) y el mail de ayuda son ajustes del tema en la administración de Moodle: no requieren cambios de código.
