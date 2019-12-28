# About the Assets folder

> More information on how to populate this folder

## base.js and base.css

These two files contain scripts and css fixes which will be applied as improvements provided by the theme.

## ./Fixes

Contains fixes for kanboard itself (e.g. the length of the search bar in the dashboard)

## ./PluginSkins

Contains the skins which can be applied. Rules:

1. They are automatically loaded if one of the theme plugin they refer to is activated;
2. The Kanext theme is loaded if the configuration specifies so.

## Other folders

Any other folder will be a fix which needs to be loaded by `Plugin.php` and probably needs a configuration option.
