<?php

// Developer configuration overrides
define('DEBUG', true);
define('PLUGIN_INSTALLER', true);

// Disable opcode caching for development so changes appear immediately
ini_set('opcache.enable', '0');
ini_set('opcache.enable_cli', '0');
