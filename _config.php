<?php
ShortcodeParser::get('default')->register('pardot_form', array('PardotShortCode', 'PardotForm'));
ShortcodeParser::get('default')->register('pardot_dynamic', array('PardotShortCode', 'PardotDynamicContent'));

HtmlEditorConfig::get('cms')->enablePlugins(array('pardot' => '/silverstripe-pardot/javascript/plugin/editor_plugin.js'));
HtmlEditorConfig::get('cms')->addButtonsToLine(2, 'pardot');