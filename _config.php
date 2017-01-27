<?php

use BluehouseGroup\Pardot\PardotShortCode;
use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;
use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')
    ->register('pardot_form', [PardotShortCode::class, 'PardotForm']);
ShortcodeParser::get('default')
    ->register('pardot_dynamic', [PardotShortCode::class, 'PardotDynamicContent']);

HTMLEditorConfig::get('cms')
    ->enablePlugins(array('pardot' => '/silverstripe-pardot/javascript/plugin/editor_plugin.js'));
HTMLEditorConfig::get('cms')
    ->addButtonsToLine(2, 'pardot');

define('BH_PARDOR_DIR', basename(__DIR__));
