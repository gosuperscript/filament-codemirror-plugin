# Examples

This directory contains example implementations to help you get started with the Filament CodeMirror plugin.

## Files

### CodeSnippet.php
Example Eloquent model for storing code snippets with:
- Title and description
- Language selection
- Code content
- Tags and categories
- Public/private visibility

### CodeSnippetResource.php
Complete Filament Resource showing best practices for using the CodeMirror component:
- Reactive language selection
- Organized sections for better UX
- Integration with other Filament form components
- Proper table columns and filters
- Code editor with appropriate settings

## Migration

To use the example model, create a migration with the following schema:

```php
Schema::create('code_snippets', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('language');
    $table->longText('code');
    $table->json('tags')->nullable();
    $table->string('category')->nullable();
    $table->boolean('is_public')->default(false);
    $table->timestamps();
});
```

## Usage

1. Copy `CodeSnippet.php` to `app/Models/`
2. Copy `CodeSnippetResource.php` to `app/Filament/Resources/`
3. Create the migration and run `php artisan migrate`
4. Access the resource in your Filament admin panel

## Customization Tips

- Adjust `minHeight` and `maxHeight` based on your needs
- Use `reactive()` on language selector to dynamically update CodeMirror's language mode
- Add more language options as needed
- Customize the theme based on user preferences or system dark mode
- Consider adding a preview feature for languages like HTML or Markdown
