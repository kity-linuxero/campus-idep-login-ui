# Implementación en Moodle: `theme_idep`

La maqueta de la raíz (`index.html`) está portada a un **tema hijo de Boost** para Moodle 5.2
que reemplaza solo la pantalla de login. Todo lo demás del campus sigue siendo Boost.

```
moodle/
  theme_idep/                         Plugin de Moodle (va en public/theme/idep del servidor)
    config.php                        Declara boost como padre y el layout de login propio
    layout/login.php                  Arma el contexto: banner (con fecha de fin), año
    templates/login.mustache          Página: banda verde, tarjeta, banner, footer con institutos
    templates/core/loginform.mustache Formulario (override de core/loginform)
    lib.php                           Todo el CSS del login (theme_idep_get_extra_scss) + fuentes
    settings.php                      Ajustes editables desde la administración
    lang/es/theme_idep.php            Textos en español (los que ve la gente)
    lang/en/theme_idep.php            Textos en inglés (obligatorio en Moodle)
    version.php                       Versión del plugin
  branding/fonts/                     Barlow y Barlow Condensed (woff2, licencia OFL)
  deploy.sh                           Despliegue al contenedor del Moodle
```

## De la maqueta a Moodle

| En `index.html` | En Moodle |
|---|---|
| Banda verde, encabezado, tarjeta, logo, divisor, footer | `templates/login.mustache` |
| Título, formulario, "¿Olvidó…?", botón | `templates/core/loginform.mustache` |
| El `<style>` | `lib.php` → `theme_idep_get_extra_scss()` |
| Textos | `lang/es/theme_idep.php` |
| `images/*.png` | se sirven en `/branding/` (los copia `deploy.sh`) |
| — (no está en la maqueta) | Banner de campaña al costado de la tarjeta (debajo en mobile) |

Las clases de la maqueta se renombraron con prefijo `idep-` porque varias chocan con Bootstrap/Boost
(`.btn-primary`, `h1`, `label`, `input[type=text]`). Equivalencias:

| Maqueta | Moodle | | Maqueta | Moodle |
|---|---|---|---|---|
| `.top-band` | `.idep-top-band` | | `.input-icon` | `.idep-input-icon` |
| `.header-text` | `.idep-header-text` | | `.input-action` | `.idep-pass-toggle` |
| `.main-content` | `.idep-main` | | `input` | `.idep-input` |
| `.login-card` | `.idep-card` | | `.forgot-link` | `.idep-link` |
| `.logo-container` | `.idep-logo` | | `.btn-primary` | `.idep-btn` |
| `.divider` | `.idep-divider` | | `.footer` | `.idep-footer` |
| `h1` | `.idep-title` | | `.institutes-img` | `.idep-institutes` |
| | | | `.copyright` | `.idep-copyright` |

Diferencias deliberadas con la maqueta:

- **Sin "Recordar usuario"**: Moodle 5.2 ya no tiene esa opción por usuario; con la configuración
  del sitio el usuario se recuerda siempre.
- **Fuentes servidas desde el propio servidor** (`/branding/fonts/`), sin pedidos a Google Fonts.
- **Banner de campaña**: es un ajuste del tema, no código.
- **Sin etiqueta "ACCESO AL CAMPUS", subtítulo ni línea de ayuda**: se sacaron para que la tarjeta entre
  completa en una pantalla de celular.

## Cambios que NO necesitan tocar código

**Administración del sitio → Apariencia → Temas → IDEP** (el engranaje en el selector de temas):

- **Banner de campaña**: mostrar sí/no, **"Mostrar hasta"** (`AAAA-MM-DD HH:MM`, hora del sitio; pasada esa fecha
  se oculta solo), imagen (vertical, ~4:5), enlace y texto alternativo.

## Si alguien sugiere un cambio en el login

1. **Diseño primero, en la maqueta.** Cambiá `index.html` (a mano o con Superdesign, ver
   `prompts/superdesign-login.md`), abrilo en el navegador y regenerá las capturas del README (comandos en
   `CLAUDE.md`). Si el cambio es solo de texto, podés saltear este paso.
2. **Portalo al tema**, usando las tablas de arriba:
   - estructura/HTML → `templates/login.mustache` o `templates/core/loginform.mustache`;
   - estilos → `lib.php`, **siempre** con selectores bajo `body.idep-login-page` y clases `idep-`;
   - textos → `lang/es/theme_idep.php` y el mismo string en `lang/en/theme_idep.php`;
   - una imagen nueva → a `images/` y agregala a la lista de `deploy.sh`.
3. **Subí la versión** en `theme_idep/version.php` (`$plugin->version = AAAAMMDDXX`, un número mayor que
   el actual). Es obligatorio si agregás textos o ajustes; si no, Moodle no los ve.
4. **Desplegá** desde el host Proxmox, en la raíz del repo: `./moodle/deploy.sh`.
5. **Verificá** (lista de abajo), commit y push.

### Verificación

- `/login/index.php` carga sin errores en la consola del navegador (CSS, fuentes, logo, banner).
- Se ve bien en desktop (1440 px) y en mobile (390 px).
- Un usuario o contraseña incorrectos muestran la alerta roja dentro de la tarjeta.
- "¿Olvidó su contraseña?" (`/login/forgot_password.php`) usa el mismo layout: revisarla también.
- El engranaje del tema abre los ajustes (si da "Section error", ver trampas).

### Volver atrás

- Inmediato: **Apariencia → Temas → Selector de temas → Boost**.
- Código: `git revert` del commit y `./moodle/deploy.sh`.

## Trampas conocidas (todas ya resueltas en el código; no reintroducirlas)

1. **Caché de CSS.** Moodle compila el SCSS y lo guarda; tras cambiar `lib.php` hay que reiniciar PHP-FPM y
   borrar `moodledata/cache/.../core_postprocessedcss`. `deploy.sh` lo hace. Además, el navegador: Ctrl+Shift+R.
2. **Altura de la página.** Boost fija `#page-wrapper` al 100 % de la ventana; por eso el patrón de fondo va en
   `#page-wrapper.idep-login` con `height: auto` (si no, se corta al hacer scroll).
3. **Ancho de los inputs.** Una hoja vieja de YUI que Moodle carga aparte trae `input[type=text]{width:12.25em}`;
   los campos necesitan su clase propia (`.idep-input`) para ganarle.
4. **Utilidades de Bootstrap con `!important`** (`.d-flex`, etc.): para anularlas hace falta `!important`.
5. **Estilos de Boost heredados.** Nunca estilar selectores sueltos (`h1`, `label`, `input`): siempre
   `body.idep-login-page .idep-…`. La clase `idep-login-page` solo existe en las páginas con este layout.
6. **Otras páginas usan este layout** ("¿Olvidó su contraseña?", cambio de contraseña, MFA): los formularios
   estándar de Moodle dentro de la tarjeta tienen estilos propios (`.idep-card .mform`).
7. **`settings.php` debe crear su propia `admin_settingpage('themesettingidep', …)`.** En 5.2 la que arma el
   core viene oculta y el engranaje da "Section error".
8. **Probar desde la red interna:** no usar `curl -L` contra el dominio (el segundo salto sale a internet), y
   la cookie de sesión es `Secure`, así que los flujos con sesión se prueban por HTTPS a través del proxy.
9. **Configuración por SQL** queda tapada por la caché de Moodle: usar `php admin/cli/cfg.php`.

## Requisitos del servidor

- Moodle 5.2 (`public/` como webroot) con Boost instalado.
- nginx sirviendo los assets fijos fuera del árbol de Moodle:

  ```nginx
  location ^~ /branding/ {
      alias /var/www/branding/;
      expires 30d;
      access_log off;
  }
  ```

## Licencia

`theme_idep` es un plugin de Moodle y adapta plantillas del core, así que se distribuye bajo
**GNU GPL v3 o posterior**, como exige Moodle. Las fuentes Barlow tienen licencia SIL OFL 1.1
(`branding/fonts/OFL-*.txt`). La maqueta del resto del repositorio sigue bajo MIT.
