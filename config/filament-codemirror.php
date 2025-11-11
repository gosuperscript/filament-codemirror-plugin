<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default CodeMirror Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file allows you to set default values for the
    | CodeMirror form component. These defaults can be overridden on a
    | per-component basis.
    |
    */

    /**
     * Default theme to use for the editor.
     * Options: 'default', 'dark', or any custom theme name.
     */
    'theme' => env('CODEMIRROR_THEME', 'default'),

    /**
     * Default language/mode for syntax highlighting.
     * Options: 'javascript', 'php', 'python', 'html', 'css', 'json', 'sql', 'markdown', 'xml', etc.
     */
    'language' => null,

    /**
     * Show line numbers by default.
     */
    'line_numbers' => true,

    /**
     * Enable line wrapping by default.
     */
    'line_wrapping' => false,

    /**
     * Default tab size (number of spaces).
     */
    'tab_size' => 2,

    /**
     * Default minimum height in pixels.
     */
    'min_height' => null,

    /**
     * Default maximum height in pixels.
     */
    'max_height' => null,

    /**
     * Default extensions to load.
     * Can be an array of extension names or configurations.
     */
    'extensions' => [],

    /**
     * Custom CodeMirror configuration options.
     * These will be merged with component-specific configurations.
     */
    'custom_configuration' => [],
];
