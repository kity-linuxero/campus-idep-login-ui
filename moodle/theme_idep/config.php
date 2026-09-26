<?php
// Config del tema hijo "idep". Hereda TODO de boost ($THEME->parents) salvo el
// login, que usa su propio layout (layout/login.php) y plantillas
// (templates/login.mustache, templates/core/loginform.mustache). No se toca
// ningún archivo de theme/boost.
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'idep';
$THEME->parents = ['boost'];
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->usefallback = true;
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

// Login propio, sin selector de idioma: el sitio usa siempre el idioma por defecto.
$THEME->layouts = [
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => false],
    ],
];

$THEME->scss = function($theme) {
    return theme_idep_get_main_scss_content($theme);
};
$THEME->prescsscallback = 'theme_idep_get_pre_scss';
$THEME->extrascsscallback = 'theme_idep_get_extra_scss';
