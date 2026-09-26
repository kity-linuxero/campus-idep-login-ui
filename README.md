# Campus IDEP — Login UI

Maqueta visual (HTML + CSS) de la pantalla de inicio de sesión del **Campus Virtual IDEP**
(Instituto de Estudios sobre Estado y Participación — ATE Provincia de Buenos Aires / CTA Autónoma),
y su implementación en Moodle como tema `theme_idep` (carpeta [`moodle/`](moodle/)).

`index.html` es la referencia visual; lo que corre en el campus es el tema de `moodle/theme_idep`.

## Vista previa

| Desktop (1440 × 900) | Mobile (390) |
|---|---|
| ![Login desktop](docs/screenshots/desktop.png) | <img src="docs/screenshots/mobile.png" alt="Login mobile" width="300"> |

Para verla en vivo alcanza con abrir [`index.html`](index.html) en el navegador (no requiere build ni servidor).

## Estructura

```
index.html                     Maqueta completa: HTML + un único <style>, sin frameworks
images/                        Assets de marca
  campusLogoSolo.png           Logo principal (siempre sobre blanco)
  campusLogoCompleto.png       Logo + fila de institutos
  institutos-fila.png          Fila de los 4 institutos (negro; se invierte a blanco en el footer)
  fondocampus.png              Patrón tileado ATE / CTA Autónoma
docs/screenshots/              Capturas usadas en este README
.superdesign/design-system.md  Sistema de diseño (paleta, tipografía, espaciados, reglas de marca)
prompts/                       Brief original y prompts usados para generar el diseño
.claude/skills/superdesign/    Skill de Superdesign para seguir iterando con Claude Code
CLAUDE.md                      Instrucciones del proyecto para agentes
moodle/                        Implementación en Moodle 5.2 (ver moodle/README.md)
  theme_idep/                  Tema hijo de Boost con este login
  branding/fonts/              Barlow / Barlow Condensed servidas desde el propio servidor
  deploy.sh                    Despliegue al contenedor del Moodle
```

## Composición

- **Fondo**: patrón institucional tileado (`fondocampus.png`, 540px; 360px en mobile) con una banda
  verde superior (`#003d18 → #00792f`, 92% de opacidad) cortada en diagonal, como la cinta negra del logo.
- **Tarjeta única centrada** (máx. 460px, radio 20px) montada sobre el borde de la banda:
  logo sobre blanco → divisor → título → formulario.
- **Formulario**: Usuario, Contraseña (con mostrar/ocultar), "Recordar usuario",
  "¿Olvidó su contraseña?" y botón **INGRESAR**.
- **Footer** negro con la fila de institutos invertida a blanco (`filter: invert(1)`).
- Sin selector de idioma, aviso de cookies, estadísticas genéricas ni acceso de invitados.

## Tokens

| Token | Valor | Uso |
|---|---|---|
| `--idep-green` | `#00792f` | Primario: botón, links, foco |
| `--idep-green-700` | `#005f25` | Hover |
| `--idep-green-900` | `#003d18` | Banda superior |
| `--idep-green-50` | `#e8f5ec` | Halo de foco |
| `--idep-mint` | `#e5ffe5` | Base del patrón |
| `--ink` | `#0b0f0c` | Títulos, etiqueta, footer |
| `--ink-700` / `--ink-500` | `#2b322d` / `#5f6b63` | Texto / texto secundario |
| `--line` | `#d6ddd8` | Bordes de inputs, divisores |

- **Tipografía**: [Barlow Condensed](https://fonts.google.com/specimen/Barlow+Condensed) 600–800 para
  títulos, etiquetas y botón; [Barlow](https://fonts.google.com/specimen/Barlow) 400–600 para el texto.
- **Medidas**: inputs y botón de 52px con radio 10px; foco = borde verde + halo de 4px;
  tarjeta con padding 36/40px (24px en mobile); breakpoint mobile en `600px`.

## En Moodle

El login ya está implementado en el tema **`theme_idep`** (tema hijo de Boost, Moodle 5.2). Detalles, mapeo
maqueta → plantillas, trampas conocidas y verificación: **[`moodle/README.md`](moodle/README.md)**.

- **El banner de campaña** se cambia desde la administración, sin código:
  *Administración del sitio → Apariencia → Temas → IDEP*. El banner tiene fecha de fin ("Mostrar hasta").
- **Si te sugieren un cambio en el login:**
  1. probalo primero en `index.html` (y regenerá las capturas);
  2. portalo a `moodle/theme_idep` (plantillas, CSS en `lib.php`, textos en `lang/`);
  3. subí `$plugin->version` en `moodle/theme_idep/version.php`;
  4. desplegá con `./moodle/deploy.sh` desde el host Proxmox y verificá;
  5. commit y push.

## Diseño

Generado con [Superdesign](https://superdesign.dev) a partir del brief en
[`prompts/brief.md`](prompts/brief.md), con ajustes manuales documentados en
[`prompts/superdesign-login.md`](prompts/superdesign-login.md).

## Licencia

La maqueta: [MIT](LICENSE) © 2026 Cristian O. Giambruni.

`moodle/theme_idep` es un plugin de Moodle y se distribuye bajo GNU GPL v3 o posterior. Las fuentes de
`moodle/branding/fonts` tienen licencia SIL OFL 1.1.

Los logos y marcas (IDEP, ATE, CTA Autónoma y los institutos) pertenecen a sus respectivas
organizaciones y no están cubiertos por la licencia MIT.
