<?php
// Tema hijo de Boost con el diseño de login del Campus Virtual IDEP.
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_idep';
$plugin->version   = 2026092704;
$plugin->requires  = 2026041000;
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '2.3';
$plugin->dependencies = [
    'theme_boost' => 2026042000,
];
