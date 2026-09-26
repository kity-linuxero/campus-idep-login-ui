# Design System — IDEP Campus Virtual

## Product context
- **Product**: Campus Virtual (Moodle) of the Instituto de Estudios sobre Estado y Participación (IDEP), linked to ATE Provincia de Buenos Aires / CTA Autónoma. Trade-union education: public-sector workers, students of CFP 410, CENS 453, IDEP Salud, IDEP Informática.
- **Audience**: adult workers, many on mobile, mixed digital literacy. Spanish (Argentina), voseo is fine but institutional tone preferred ("Ingresá", "¿Olvidó su contraseña?").
- **Target page**: Login screen only (visual mockup to be ported to a Moodle theme `theme_idep`).
- **JTBD**: "I want to get into my courses quickly and feel this is *my* institute's campus, not a generic admin panel."

## Required login elements
- Logo (brand) with strong contrast.
- Username field ("Usuario" / DNI), password field ("Contraseña") with show/hide toggle.
- Primary button "Ingresar".
- Link "¿Olvidó su contraseña?".
- Free copy allowed: short welcome headline, subtitle, small help/contact line, footer with the four institutes.
- **FORBIDDEN**: language selector, cookie notice, generic stats ("500M users"), guest-access buttons, social login, any Moodle default chrome.

## Brand assets (use exactly, never recreate)
- `campusLogoSolo` — main logo "IDEP Campus Virtual" (green #00922f-ish fill, black outline, black ribbon with white text, black script "Virtual"). Transparent PNG. **Must sit on white or very light background** — it loses contrast on green or black.
- `campusLogoCompleto` — same logo + row of 4 institute sub-logos (black). Only on white.
- `institutos-fila` — just the 4 black institute sub-logos (IDEP Salud, CFP 410 Omar Núñez, IDEP Informática, Cens 453 Carlos Fuentealba), 1069×214 transparent PNG. Only on white/light surfaces, or inverted to white (`filter: invert(1)`) on black/green.
- `fondocampus` — tileable light mint pattern (#e5ffe5 base) with pale ATE / CTA Autónoma seals. Use as `background-repeat: repeat`, typically `background-size: 540px auto`.

## Color
| Token | Value | Use |
|---|---|---|
| `--idep-green` | `#00792f` | Institutional primary: buttons, focus, accents, bands |
| `--idep-green-700` | `#005f25` | Hover / pressed |
| `--idep-green-900` | `#003d18` | Deep backgrounds, overlays |
| `--idep-green-50` | `#e8f5ec` | Tints, input focus halo |
| `--idep-mint` | `#e5ffe5` | Pattern base (from fondocampus) |
| `--ink` | `#0b0f0c` | Black (logo ribbon black), headings, strong strips |
| `--ink-700` | `#2b322d` | Body text |
| `--ink-500` | `#5f6b63` | Muted text, labels |
| `--line` | `#d6ddd8` | Input borders, dividers |
| `--white` | `#ffffff` | Card surfaces, logo backgrounds |
| `--danger` | `#c62828` | Errors |

Only green / black / white + neutral greys. No other hues (no blue, purple, orange, gradients to other hues). Green-to-deep-green gradients are allowed.

## Typography
- **Display / labels**: `Barlow Condensed` (600, 700, 800) — echoes the condensed bold of the logo ribbon. Uppercase eyebrows with letter-spacing 0.08em.
- **UI / body**: `Barlow` (400, 500, 600).
- Scale: eyebrow 13px/700 uppercase; H1 34–40px desktop / 28px mobile Barlow Condensed 700, line-height 1.05; body 16px/1.5; labels 14px/600; small 13px.

## Shape, spacing, depth
- 8px spacing grid. Card padding 40px desktop / 24px mobile.
- Radius: inputs & buttons 10px; card 20px; pills 999px.
- Inputs: 52px tall, 1.5px `--line` border, white fill; focus = 2px `--idep-green` border + 4px `--idep-green-50` ring.
- Primary button: 52px tall, full width, `--idep-green` bg, white Barlow Condensed 700 uppercase 17px, letter-spacing .06em, subtle arrow icon; hover `--idep-green-700`, slight lift.
- Shadow (card): `0 24px 60px -20px rgba(0,61,24,.35), 0 2px 6px rgba(0,0,0,.06)`.
- Signature detail: a black slanted "ribbon" tag (like the logo's black label, right edge cut at an angle) used for eyebrows/section tags.

## Motion
- Card fades/slides up 12px on load (400ms ease-out). Button hover lift 1px. Focus transitions 150ms. Respect `prefers-reduced-motion`.

## Layout principles
- Focus on the form: one clear surface, logo above it on white.
- Institutional background pattern present but calm (pattern + green overlay or split bands).
- Responsive: desktop 1440, mobile 390. On mobile the form fills the width with 16px gutters, logo stays on white, footer institutes wrap 2×2.
- Plain HTML + CSS only (no framework), easy to port to Moodle Mustache (`core/loginform`).
