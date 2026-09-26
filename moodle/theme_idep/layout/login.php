<?php
// Layout de login propio del tema "idep" (diseño campus-idep-login-ui):
// página completa con banda verde, tarjeta única, banner de campaña opcional
// y footer con los institutos. El formulario en sí sale de core/loginform
// (sobrescrito en templates/core/loginform.mustache).
defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes(['idep-login-page']);

// "Mostrar hasta" (AAAA-MM-DD HH:MM, hora del sitio): pasada esa fecha el
// banner deja de mostrarse solo, aunque siga tildado "Mostrar banner".
$bannerexpired = false;
$bannerexpires = get_config('theme_idep', 'bannerexpires');
if (!empty($bannerexpires)) {
    $expires = DateTime::createFromFormat('Y-m-d H:i', $bannerexpires, core_date::get_server_timezone_object());
    $bannerexpired = $expires && $expires->getTimestamp() <= time();
}

$banner = null;
if (get_config('theme_idep', 'bannerenabled') && !$bannerexpired) {
    $imageurl = $PAGE->theme->setting_file_url('bannerimage', 'bannerimage');
    if (!empty($imageurl)) {
        $banner = [
            'imageurl' => $imageurl,
            'linkurl' => get_config('theme_idep', 'bannerurl') ?: null,
            'alt' => get_config('theme_idep', 'banneralt') ?: '',
        ];
    }
}

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true,
        ['context' => context_course::instance(SITEID), 'escape' => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'banner' => $banner,
    'year' => date('Y'),
];

echo $OUTPUT->render_from_template('theme_idep/login', $templatecontext);
