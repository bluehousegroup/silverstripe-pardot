<?php

use BluehouseGroup\Pardot\PardotShortCode;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\Core\Manifest\ModuleLoader;

ShortcodeParser::get('default')
    ->register('pardot_form', [PardotShortCode::class, 'PardotForm']);
ShortcodeParser::get('default')
    ->register('pardot_dynamic', [PardotShortCode::class, 'PardotDynamicContent']);

$pardotModule = ModuleLoader::inst()->getManifest()->getModule('bluehousegroup/silverstripe-pardot');

// Enable insert-link to internal pages
TinyMCEConfig::get('cms')
    ->enablePlugins(['pardot' => $pardotModule->getResource('javascript/plugin/editor_plugin.js')])
    ->addButtonsToLine(2, 'pardot');

define('BH_PARDOR_DIR', basename(__DIR__));
