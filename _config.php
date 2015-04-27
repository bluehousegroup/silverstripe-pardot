<?php
ShortcodeParser::get('default')->register('pardot_form', array('PardotShortCode', 'PardotForm'));
ShortcodeParser::get('default')->register('pardot_dynamic', array('PardotShortCode', 'PardotDynamicContent'));

