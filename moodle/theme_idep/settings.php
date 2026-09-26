<?php
// Ajustes del tema "idep": banner de campaña del login (hoy Enrédate 26).
// Se editan en Administración del sitio → Apariencia → Temas → IDEP.
defined('MOODLE_INTERNAL') || die();

// En Moodle 5.2 appearance.php crea la página del tema oculta y solo la agrega
// al árbol si el settings.php la reemplaza/destapa; si no, el engranaje del
// selector de temas da "Section error".
$settings = new admin_settingpage('themesettingidep', get_string('configtitle', 'theme_idep'));

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('theme_idep/bannerheading',
        get_string('bannerheading', 'theme_idep'), get_string('bannerheading_desc', 'theme_idep')));

    $settings->add(new admin_setting_configcheckbox('theme_idep/bannerenabled',
        get_string('bannerenabled', 'theme_idep'), get_string('bannerenabled_desc', 'theme_idep'), 1));

    $settings->add(new admin_setting_configtext('theme_idep/bannerexpires',
        get_string('bannerexpires', 'theme_idep'), get_string('bannerexpires_desc', 'theme_idep'), '',
        '/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2})?$/'));

    $setting = new admin_setting_configstoredfile('theme_idep/bannerimage',
        get_string('bannerimage', 'theme_idep'), get_string('bannerimage_desc', 'theme_idep'), 'bannerimage', 0,
        ['maxfiles' => 1, 'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp']]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    $settings->add(new admin_setting_configtext('theme_idep/bannerurl',
        get_string('bannerurl', 'theme_idep'), get_string('bannerurl_desc', 'theme_idep'), '', PARAM_URL));

    $settings->add(new admin_setting_configtext('theme_idep/banneralt',
        get_string('banneralt', 'theme_idep'), get_string('banneralt_desc', 'theme_idep'), '', PARAM_TEXT));
}
