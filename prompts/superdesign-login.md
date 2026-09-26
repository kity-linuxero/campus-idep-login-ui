# Superdesign — generación del login

## Proyecto

| | |
|---|---|
| Proyecto | `IDEP Campus Virtual — Login` (`d4cbf9f4-7031-4858-bed1-8ab72c299aa1`) |
| Draft | `747f598b-1896-4bfc-9b4e-b5036ba099cb` (v1 = generación, v3 = versión final con ajustes) |
| Modelo | `gemini-3.1-pro` |
| Contexto | `.superdesign/design-system.md` |
| Brand assets | `images-campusLogoSolo.png`, `images-institutos-fila.png`, `images-fondocampus.png` |

Para seguir iterando sobre el mismo draft:

```bash
npx --yes @superdesign/cli@latest iterate-design-draft \
  --draft-id 747f598b-1896-4bfc-9b4e-b5036ba099cb --mode replace \
  --context-file .superdesign/design-system.md \
  --reference-id images-campusLogoSolo.png images-institutos-fila.png images-fondocampus.png \
  -p "<cambio>. Use ONLY the fonts, colors, spacing, and component styles defined in the design system."
```

Si se edita `index.html` a mano y se quiere subir como nueva versión, primero volver a poner las URLs
públicas de los assets (el canvas no resuelve rutas relativas) y luego:

```bash
npx --yes @superdesign/cli@latest import-design-draft \
  --into 747f598b-1896-4bfc-9b4e-b5036ba099cb --html-file index.html --generated-by <modelo>
```

## Prompt de generación (v1)

> Las URLs de los assets se reemplazaron por las rutas locales de `images/`.

```text
Login screen for 'IDEP Campus Virtual' (Moodle), Spanish (Argentina). Plain semantic HTML + one <style> block, no frameworks, fully responsive (desktop 1440 and mobile 390 via media queries). NOT a two-column split and NOT a generic admin login.

COMPOSITION (single centered focal surface):
- Page background: the institutional pattern images/fondocampus.png tiled (background-repeat: repeat; background-size: 540px auto). Over the TOP ~46% of the viewport lay a deep-green band (#003d18 → #00792f linear gradient, ~92% opacity so the seals faintly show through) whose bottom edge is cut on a diagonal (clip-path polygon, lower on the left, higher on the right — echoing the slanted cut of the black ribbon in the logo). Below the band the light mint pattern shows plainly.
- Centered white card (max-width 460px, radius 20px, shadow per design system) straddling the band edge so it overlaps green above and mint below. Card fades/slides up on load.
- Card TOP: white area with the logo image images/campusLogoSolo.png, width ~280px desktop / 220px mobile, centered, generous padding. Logo sits ONLY on white — never on green or black.
- Under the logo, a thin 1px divider, then a black slanted ribbon tag (black bg, white Barlow Condensed 700 uppercase 13px, letter-spacing .08em, right edge cut at an angle via clip-path) reading 'ACCESO AL CAMPUS'.
- Headline 'Bienvenida/o de nuevo' (Barlow Condensed 700, 36px) and subtitle 'Ingresá con tu usuario y contraseña para acceder a tus cursos.' (Barlow 16px, #5f6b63).
- Form: label 'Usuario' + input with leading user icon (inline SVG, stroke icons) placeholder 'DNI o nombre de usuario'; label 'Contraseña' + input with leading lock icon and trailing eye show/hide button; a row with a small 'Recordar usuario' checkbox (green accent) on the left and the link '¿Olvidó su contraseña?' (green #00792f, 600, underline on hover) on the right. Primary full-width button 'INGRESAR' with arrow icon, #00792f, hover #005f25.
- Below button inside the card: small muted help line '¿Problemas para ingresar? Escribinos a campus@idep.org.ar'.
- Above the card, on the green band, small white text in Barlow Condensed uppercase: 'Instituto de Estudios sobre Estado y Participación · ATE Provincia de Buenos Aires' (desktop only, centered, 70% opacity white).
- FOOTER: full-width solid black (#0b0f0c) strip at the bottom with the institutes row image images/institutos-fila.png rendered WHITE via filter: invert(1) (max-height 56px desktop, 44px mobile), preceded by tiny white uppercase label 'Nuestros institutos', and a copyright line '© 2026 IDEP — CTA Autónoma'.
- Mobile (<=600px): band covers top ~34%, card full width with 16px side gutters and 24px padding, logo 220px, footer institutes image scales to 100% width.

Use the exact supplied logo image URL in the logo position — do NOT replace it with initials, emoji, a generic mark, an invented SVG or text alone. Do NOT include a language selector, cookie notice, stats, guest access or social login. Use ONLY the fonts (Barlow, Barlow Condensed from Google Fonts), colors (green #00792f family, black, white, neutral greys), spacing and component styles defined in the design system. Do not introduce any fonts, colors, or visual styles not in the design system.
```

## Ajustes manuales (v2–v3)

- El texto institucional de la banda pasó de `position: absolute` a flujo normal: la tarjeta lo tapaba.
- Espaciados más compactos (logo 248px, padding de tarjeta 36/40/32px, márgenes de 18–24px) para que el footer entre en 1440×900.
- Footer en una sola fila en desktop (etiqueta · institutos · copyright) y en columna en mobile, con los institutos al 100% del ancho.
- Placeholder de `#d6ddd8` a `#9aa59e` (el original no tenía contraste suficiente).
- Patrón de fondo a 360px en mobile.
- Estados `:focus-visible` para botón, links y botón de mostrar contraseña.
- Script de mostrar/ocultar contraseña (solo maqueta).
- Todo envuelto en un único `<div class="page">` e `id` en los links (convención del canvas de Superdesign).
- En el repo: rutas de imágenes locales y sin los atributos `data-sd-id` del editor.
