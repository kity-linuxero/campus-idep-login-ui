# Campus IDEP — Login UI

Maqueta visual estática del login del Campus Virtual IDEP (Moodle), que se porta a mano al tema `theme_idep`.

- `index.html` es la única fuente: HTML semántico + un solo `<style>`, sin frameworks ni build. Mantenerlo así para que sea fácil de pasar a Mustache (`core/loginform`).
- El sistema de diseño está en `.superdesign/design-system.md` y es una restricción, no una sugerencia: solo verde IDEP (`#00792f` y sus tonos), negro, blanco y grises neutros; solo Barlow y Barlow Condensed.
- El logo (`images/campusLogoSolo.png`) va siempre sobre blanco. La fila de institutos es negra: sobre fondo oscuro se usa con `filter: invert(1)`. Nunca reemplazar el logo por texto, iniciales o un SVG inventado.
- Prohibido en la pantalla: selector de idioma, aviso de cookies, estadísticas genéricas, acceso de invitados, login social.
- Para iterar el diseño con Superdesign, usar la skill en `.claude/skills/superdesign/` y los IDs de proyecto/draft de `prompts/superdesign-login.md`.
- Después de cambiar `index.html`, regenerar las capturas del README:

  ```bash
  google-chrome --headless=new --hide-scrollbars --window-size=1440,900 --virtual-time-budget=5000 --screenshot=docs/screenshots/desktop.png "file://$PWD/index.html"
  google-chrome --headless=new --hide-scrollbars --force-device-scale-factor=2 --window-size=390,1000 --virtual-time-budget=5000 --screenshot=docs/screenshots/mobile.png "file://$PWD/index.html"
  ```
