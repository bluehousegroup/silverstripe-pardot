<?php

use BluehouseGroup\Pardot\ParseShortCode;
use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;
use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')
    ->register('pardot_form', array(PardotShortCode::class, 'PardotForm'));
ShortcodeParser::get('default')
    ->register('pardot_dynamic', array(PardotShortCode::class, 'PardotDynamicContent'));

HTMLEditorConfig::get('cms')
    ->enablePlugins(array('pardot' => '/silverstripe-pardot/javascript/plugin/editor_plugin.js'));
HTMLEditorConfig::get('cms')
    ->addButtonsToLine(2, 'pardot');
