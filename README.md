# Filament CodeMirror Plugin

A powerful and highly configurable [Filament v4](https://filamentphp.com) form component that integrates [CodeMirror 6](https://codemirror.net/) for editing code with syntax highlighting, extensions, and language support.

## Features

- 🎨 **Extensive Language Support**: Supports all CodeMirror 6 language packages including JavaScript, TypeScript, Python, PHP, HTML, CSS, JSON, SQL, Markdown, XML, Java, C++, Rust, Go, and many more
- 🌗 **Flexible Themes**: Dynamic theme loading supporting all CodeMirror 6 themes
- ⚙️ **Highly Configurable**: Line numbers, line wrapping, tab size, height constraints, and more
- 🔌 **Extensible**: Support for custom CodeMirror extensions
- 🚀 **Modern**: Built on CodeMirror 6 with ESM modules
- 💪 **Type Safe**: Full IDE autocomplete support
- 📱 **Responsive**: Works great on all screen sizes

## Installation

You can install the package via composer:

```bash
composer require gosuperscript/filament-codemirror-plugin
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-codemirror-config"
```

This is the contents of the published config file:

```php
return [
    'theme' => env('CODEMIRROR_THEME', 'default'),
    'language' => null,
    'line_numbers' => true,
    'line_wrapping' => false,
    'tab_size' => 2,
    'min_height' => null,
    'max_height' => null,
    'extensions' => [],
    'custom_configuration' => [],
];
```

## Usage

### Basic Usage

```php
use Superscript\FilamentCodemirror\Forms\Components\CodeMirror;

CodeMirror::make('code')
    ->label('Code Editor')
    ->language('javascript')
```

### With Language Support

```php
CodeMirror::make('javascript_code')
    ->label('JavaScript Code')
    ->language('javascript')
    ->lineNumbers()
    ->tabSize(4)
```

### Supported Languages

The component dynamically loads language support from CodeMirror's official language packages. It supports all languages available in the `@codemirror/lang-*` packages:

```php
// JavaScript/TypeScript
CodeMirror::make('js_code')->language('javascript')
CodeMirror::make('ts_code')->language('typescript')

// Web Languages
CodeMirror::make('html_code')->language('html')
CodeMirror::make('css_code')->language('css')
CodeMirror::make('xml_code')->language('xml')

// Programming Languages
CodeMirror::make('python_code')->language('python')
CodeMirror::make('php_code')->language('php')
CodeMirror::make('java_code')->language('java')
CodeMirror::make('cpp_code')->language('cpp')
CodeMirror::make('rust_code')->language('rust')
CodeMirror::make('go_code')->language('go')

// Data Formats
CodeMirror::make('json_code')->language('json')
CodeMirror::make('yaml_code')->language('yaml')

// Database
CodeMirror::make('sql_code')->language('sql')

// Markup
CodeMirror::make('markdown_code')->language('markdown')

// And many more - any language supported by CodeMirror 6 can be used
```

### With Dark Theme

```php
CodeMirror::make('code')
    ->language('javascript')
    ->theme('dark')
```

### With Line Wrapping

```php
CodeMirror::make('code')
    ->language('python')
    ->lineWrapping()
```

### With Custom Height

```php
CodeMirror::make('code')
    ->language('html')
    ->minHeight(300)
    ->maxHeight(600)
```

### Read-Only Mode

```php
CodeMirror::make('code')
    ->language('javascript')
    ->readOnly()
```

### Without Line Numbers

```php
CodeMirror::make('code')
    ->language('css')
    ->lineNumbers(false)
```

### Custom Tab Size

```php
CodeMirror::make('code')
    ->language('javascript')
    ->tabSize(4)
```

### Advanced Configuration

```php
CodeMirror::make('code')
    ->language('javascript')
    ->theme('dark')
    ->lineNumbers()
    ->lineWrapping()
    ->tabSize(2)
    ->minHeight(200)
    ->maxHeight(800)
    ->configuration([
        // Custom CodeMirror configuration options
    ])
```

### Using with Closures

All configuration methods accept closures for dynamic values:

```php
CodeMirror::make('code')
    ->language(fn () => auth()->user()->preferred_language ?? 'javascript')
    ->theme(fn () => auth()->user()->dark_mode ? 'dark' : 'default')
    ->readOnly(fn () => !auth()->user()->can('edit_code'))
    ->tabSize(fn () => auth()->user()->tab_size ?? 2)
```

### Complete Example in a Resource

```php
<?php

namespace App\Filament\Resources;

use App\Models\Snippet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Superscript\FilamentCodemirror\Forms\Components\CodeMirror;

class SnippetResource extends Resource
{
    protected static ?string $model = Snippet::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('language')
                    ->options([
                        'javascript' => 'JavaScript',
                        'typescript' => 'TypeScript',
                        'python' => 'Python',
                        'php' => 'PHP',
                        'html' => 'HTML',
                        'css' => 'CSS',
                        'json' => 'JSON',
                        'sql' => 'SQL',
                        'markdown' => 'Markdown',
                        'xml' => 'XML',
                    ])
                    ->required()
                    ->reactive(),
                
                CodeMirror::make('code')
                    ->label('Code')
                    ->language(fn ($get) => $get('language') ?? 'javascript')
                    ->lineNumbers()
                    ->lineWrapping()
                    ->minHeight(400)
                    ->maxHeight(800)
                    ->required(),
                
                Forms\Components\Textarea::make('description')
                    ->rows(3),
            ]);
    }
}
```

## API Reference

### Methods

#### `language(string|Closure|null $language)`
Set the programming language for syntax highlighting.

**Dynamic Language Loading:**
The component dynamically loads language support from CodeMirror's CDN. Any language available in the `@codemirror/lang-*` packages is supported. Common languages include:
- JavaScript (`javascript` or `js`), TypeScript (`typescript` or `ts`)
- Python (`python`), PHP (`php`), Java (`java`), C++ (`cpp`)
- HTML (`html`), CSS (`css`), XML (`xml`)
- JSON (`json`), YAML (`yaml`), TOML (`toml`)
- SQL (`sql`), Markdown (`markdown` or `md`)
- Rust (`rust`), Go (`go`), Ruby (`ruby`)
- And many more...

The component will attempt to load the specified language package automatically.

#### `theme(string|Closure $theme)`
Set the editor theme. The component dynamically loads themes from CodeMirror's theme packages.

**Supported themes:** `default`, `dark` (oneDark), and any other CodeMirror 6 theme package available on CDN.

#### `lineNumbers(bool|Closure $condition = true)`
Enable or disable line numbers.

#### `lineWrapping(bool|Closure $condition = true)`
Enable or disable line wrapping.

#### `readOnly(bool|Closure $condition = true)`
Set the editor to read-only mode.

#### `tabSize(int|Closure $size)`
Set the number of spaces per tab.

#### `minHeight(int|Closure $height)`
Set the minimum height in pixels.

#### `maxHeight(int|Closure $height)`
Set the maximum height in pixels.

#### `extensions(array|Closure $extensions)`
Set custom CodeMirror extensions.

#### `configuration(array|Closure $config)`
Set custom CodeMirror configuration options.

## Configuration

You can set default values for all CodeMirror components in the config file:

```php
// config/filament-codemirror.php

return [
    'theme' => 'dark', // Default theme
    'language' => 'javascript', // Default language
    'line_numbers' => true,
    'line_wrapping' => false,
    'tab_size' => 4,
    'min_height' => 300,
    'max_height' => null,
];
```

## Requirements

- PHP 8.4 or higher
- Laravel 11.x
- Filament 4.x

## Credits

- [gosuperscript](https://github.com/gosuperscript)
- [CodeMirror](https://codemirror.net/)
- [Filament](https://filamentphp.com/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.