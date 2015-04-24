<?php
ShortcodeParser::get('default')->register('pardot_shortcode', array('PardotShortCode', 'PardotForm'));
ShortcodeParser::get('default')->register('pardot_shortcode_dynamic', array('PardotShortCode', 'PardotDynamicContent'));

