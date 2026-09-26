<?php
// Callbacks del tema "idep". El login usa el diseño de
// github.com/kity-linuxero/campus-idep-login-ui portado a Moodle. Los assets
// fijos (logo, patrón, fila de institutos, fuentes Barlow) se sirven como
// estáticos desde /branding/ (nginx, fuera del árbol de git de Moodle); el
// banner de campaña es un ajuste del tema (archivo subido desde la admin).
defined('MOODLE_INTERNAL') || die();

/**
 * Contenido SCSS principal: reusa el preset "default" de Boost tal cual.
 */
function theme_idep_get_main_scss_content($theme) {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
}

/**
 * Variables SCSS antes del preset: verde institucional como primario del sitio.
 */
function theme_idep_get_pre_scss($theme) {
    return '$primary: #00792f;' . "\n";
}

/**
 * Sirve los archivos subidos en los ajustes del tema (banner de campaña).
 */
function theme_idep_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel == CONTEXT_SYSTEM && $filearea === 'bannerimage') {
        $theme = theme_config::load('idep');
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
    send_file_not_found();
}

/**
 * CSS del login. Todo va acotado a body.idep-login-page (clase que agrega
 * layout/login.php), así no afecta al resto del sitio.
 */
function theme_idep_get_extra_scss($theme) {
    return <<<'CSS'
@font-face { font-family: 'Barlow'; font-style: normal; font-weight: 400; font-display: swap; src: url('/branding/fonts/barlow-400.woff2') format('woff2'); }
@font-face { font-family: 'Barlow'; font-style: normal; font-weight: 500; font-display: swap; src: url('/branding/fonts/barlow-500.woff2') format('woff2'); }
@font-face { font-family: 'Barlow'; font-style: normal; font-weight: 600; font-display: swap; src: url('/branding/fonts/barlow-600.woff2') format('woff2'); }
@font-face { font-family: 'Barlow Condensed'; font-style: normal; font-weight: 600; font-display: swap; src: url('/branding/fonts/barlowcondensed-600.woff2') format('woff2'); }
@font-face { font-family: 'Barlow Condensed'; font-style: normal; font-weight: 700; font-display: swap; src: url('/branding/fonts/barlowcondensed-700.woff2') format('woff2'); }
@font-face { font-family: 'Barlow Condensed'; font-style: normal; font-weight: 800; font-display: swap; src: url('/branding/fonts/barlowcondensed-800.woff2') format('woff2'); }

body.idep-login-page {
    --idep-green: #00792f;
    --idep-green-700: #005f25;
    --idep-green-900: #003d18;
    --idep-green-50: #e8f5ec;
    --idep-mint: #e5ffe5;
    --idep-ink: #0b0f0c;
    --idep-ink-700: #2b322d;
    --idep-ink-500: #5f6b63;
    --idep-line: #d6ddd8;
    --idep-danger: #c62828;
    font-family: 'Barlow', sans-serif;
    color: var(--idep-ink-700);
    background-color: var(--idep-mint);
}

/* El modal del flyer (additionalhtmltopofbody) queda reemplazado por el banner de la página. */
body.idep-login-page #flyer-modal {
    display: none !important;
}

/* El patrón va en el contenedor (no en body): Boost fija body a la altura de
   la ventana y el fondo se cortaba al hacer scroll. */
body.idep-login-page #page-wrapper.idep-login {
    position: relative;
    height: auto;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: var(--idep-mint);
    background-image: url('/branding/fondocampus.png');
    background-repeat: repeat;
    background-size: 540px auto;
}

body.idep-login-page .idep-top-band {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 46vh;
    background: linear-gradient(180deg, var(--idep-green-900) 0%, var(--idep-green) 100%);
    opacity: .92;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 85%);
    z-index: 0;
}

body.idep-login-page .idep-header-text {
    position: relative;
    z-index: 1;
    padding: 28px 16px 0;
    text-align: center;
    color: rgba(255, 255, 255, .7);
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}

body.idep-login-page .idep-main {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 32px;
    padding: 20px 16px 40px;
}

body.idep-login-page .idep-card {
    background: #fff;
    width: 100%;
    max-width: 460px;
    border-radius: 20px;
    box-shadow: 0 24px 60px -20px rgba(0, 61, 24, .35), 0 2px 6px rgba(0, 0, 0, .06);
    padding: 36px 40px 32px;
    animation: idepSlideUp 400ms ease-out forwards;
    opacity: 0;
    transform: translateY(12px);
}

@keyframes idepSlideUp {
    to { opacity: 1; transform: translateY(0); }
}

body.idep-login-page .idep-logo {
    text-align: center;
    margin-bottom: 20px;
}

body.idep-login-page .idep-logo img {
    width: 248px;
    max-width: 100%;
    height: auto;
}

body.idep-login-page .idep-divider {
    height: 1px;
    background: var(--idep-line);
    margin-bottom: 20px;
}

body.idep-login-page .idep-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 36px;
    font-weight: 700;
    color: var(--idep-ink);
    line-height: 1.05;
    margin: 0 0 20px;
}

body.idep-login-page .idep-alert {
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 18px;
    font-size: 15px;
}

body.idep-login-page .idep-alert--danger {
    background: #fdecea;
    color: var(--idep-danger);
    border: 1px solid #f5c6c2;
}

body.idep-login-page .idep-alert--info {
    background: var(--idep-green-50);
    color: var(--idep-green-700);
    border: 1px solid #bfe0cb;
}

body.idep-login-page .idep-field {
    margin-bottom: 18px;
}

body.idep-login-page .idep-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--idep-ink-700);
    margin-bottom: 8px;
}

body.idep-login-page .idep-input-wrap {
    position: relative;
}

body.idep-login-page .idep-input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    stroke: var(--idep-ink-500);
    stroke-width: 2;
    fill: none;
    pointer-events: none;
}

body.idep-login-page .idep-input {
    display: block;
    width: 100%;
    height: 52px;
    background: #fff;
    border: 1.5px solid var(--idep-line);
    border-radius: 10px;
    padding: 0 16px 0 46px;
    font-family: 'Barlow', sans-serif;
    font-size: 16px;
    color: var(--idep-ink-700);
    transition: border-color 150ms ease, box-shadow 150ms ease;
}

body.idep-login-page .idep-input--action {
    padding-right: 48px;
}

body.idep-login-page .idep-input:focus {
    outline: none;
    border-color: var(--idep-green);
    box-shadow: 0 0 0 4px var(--idep-green-50);
}

body.idep-login-page .idep-input::placeholder {
    color: #9aa59e;
}

body.idep-login-page .idep-pass-toggle {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    border-radius: 8px;
    padding: 0;
    cursor: pointer;
}

body.idep-login-page .idep-pass-toggle svg {
    width: 20px;
    height: 20px;
    stroke: var(--idep-ink-500);
    stroke-width: 2;
    fill: none;
}

body.idep-login-page .idep-pass-toggle .idep-eye-off,
body.idep-login-page .idep-pass-toggle.is-visible .idep-eye {
    display: none;
}

body.idep-login-page .idep-pass-toggle.is-visible .idep-eye-off {
    display: block;
}

body.idep-login-page .idep-form-row {
    display: flex;
    justify-content: flex-end;
    margin: -4px 0 24px;
}

body.idep-login-page .idep-link,
body.idep-login-page .idep-help a {
    color: var(--idep-green);
    font-weight: 600;
    text-decoration: none;
}

body.idep-login-page .idep-link {
    font-size: 14px;
}

body.idep-login-page .idep-link:hover,
body.idep-login-page .idep-help a:hover {
    text-decoration: underline;
}

body.idep-login-page .idep-btn {
    width: 100%;
    height: 52px;
    background: var(--idep-green);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 17px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    transition: background-color 150ms ease, transform 150ms ease;
    margin-bottom: 20px;
}

body.idep-login-page .idep-btn:hover {
    background: var(--idep-green-700);
    color: #fff;
    transform: translateY(-1px);
}

/* El botón INGRESAR es lo último de la tarjeta: sin margen extra abajo. */
body.idep-login-page .idep-form .idep-btn {
    margin-bottom: 0;
}

body.idep-login-page .idep-btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2.5;
    fill: none;
}

body.idep-login-page .idep-btn--outline {
    background: #fff;
    color: var(--idep-ink-700);
    border: 1.5px solid var(--idep-line);
}

body.idep-login-page .idep-btn--outline:hover {
    background: var(--idep-green-50);
    color: var(--idep-ink);
}

body.idep-login-page .idep-btn:focus-visible,
body.idep-login-page .idep-pass-toggle:focus-visible,
body.idep-login-page .idep-link:focus-visible,
body.idep-login-page .idep-help a:focus-visible,
body.idep-login-page .idep-banner a:focus-visible {
    outline: 2px solid var(--idep-green);
    outline-offset: 3px;
}

body.idep-login-page .idep-help {
    text-align: center;
    font-size: 13px;
    color: var(--idep-ink-500);
    margin: 0;
}

/* Formularios estándar de Moodle dentro de la tarjeta (p. ej. "¿Olvidó su
   contraseña?", que usa este mismo layout): etiquetas arriba del campo y la
   misma tipografía/medidas que el login. */
body.idep-login-page .idep-card .mform h3 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--idep-ink);
    margin-bottom: 8px;
}

body.idep-login-page .idep-card .mform .fitem.row {
    flex-direction: column;
    margin-left: 0;
    margin-right: 0;
}

body.idep-login-page .idep-card .mform .fitem.row > [class*="col-md-"] {
    flex: 0 0 100%;
    max-width: 100%;
    width: 100%;
    padding-left: 0;
    padding-right: 0;
}

body.idep-login-page .idep-card .mform .col-form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--idep-ink-700);
    margin-bottom: 8px;
}

body.idep-login-page .idep-card .mform input.form-control {
    width: 100% !important;
    height: 52px;
    border: 1.5px solid var(--idep-line);
    border-radius: 10px;
    font-family: 'Barlow', sans-serif;
    font-size: 16px;
}

body.idep-login-page .idep-card .mform input.form-control:focus {
    border-color: var(--idep-green);
    box-shadow: 0 0 0 4px var(--idep-green-50);
}

body.idep-login-page .idep-card .mform .btn {
    border-radius: 10px;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 10px 24px;
}

/* Banner de campaña (Enrédate 26): al costado de la tarjeta en desktop. */
body.idep-login-page .idep-banner {
    width: 100%;
    max-width: 420px;
    animation: idepSlideUp 400ms ease-out 120ms forwards;
    opacity: 0;
    transform: translateY(12px);
}

body.idep-login-page .idep-banner a,
body.idep-login-page .idep-banner img {
    display: block;
    border-radius: 20px;
}

body.idep-login-page .idep-banner img {
    width: 100%;
    height: auto;
    box-shadow: 0 24px 60px -20px rgba(0, 61, 24, .45), 0 2px 6px rgba(0, 0, 0, .08);
    transition: transform 150ms ease;
}

body.idep-login-page .idep-banner a:hover img {
    transform: translateY(-2px);
}

body.idep-login-page .idep-footer {
    position: relative;
    z-index: 1;
    background: var(--idep-ink);
    padding: 18px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

body.idep-login-page .idep-footer-label {
    flex: 1;
    color: rgba(255, 255, 255, .6);
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
}

body.idep-login-page .idep-institutes {
    max-width: 100%;
    max-height: 48px;
    filter: invert(1);
}

body.idep-login-page .idep-copyright {
    flex: 1;
    text-align: right;
    color: rgba(255, 255, 255, .4);
    font-size: 13px;
}

@media (max-width: 991.98px) {
    body.idep-login-page .idep-main {
        flex-direction: column;
    }
    body.idep-login-page .idep-banner {
        max-width: 460px;
    }
}

@media (max-width: 600px) {
    body.idep-login-page #page-wrapper.idep-login {
        background-size: 360px auto;
    }
    body.idep-login-page .idep-top-band {
        height: 34vh;
    }
    body.idep-login-page .idep-header-text {
        display: none;
    }
    body.idep-login-page .idep-main {
        gap: 20px;
    }
    body.idep-login-page .idep-card {
        padding: 24px;
    }
    body.idep-login-page .idep-logo img {
        width: 220px;
    }
    body.idep-login-page .idep-title {
        font-size: 28px;
    }
    body.idep-login-page .idep-footer {
        flex-direction: column;
        gap: 14px;
        padding: 24px 16px;
        text-align: center;
    }
    body.idep-login-page .idep-copyright {
        text-align: center;
    }
    body.idep-login-page .idep-institutes {
        max-height: none;
        width: 100%;
    }
}

@media (prefers-reduced-motion: reduce) {
    body.idep-login-page .idep-card,
    body.idep-login-page .idep-banner {
        animation: none;
        opacity: 1;
        transform: none;
    }
    body.idep-login-page .idep-btn:hover,
    body.idep-login-page .idep-banner a:hover img {
        transform: none;
    }
}
CSS;
}
