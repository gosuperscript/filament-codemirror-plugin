<?php

use Superscript\FilamentCodemirror\Forms\Components\CodeMirror;

it('can create a CodeMirror component', function () {
    $component = CodeMirror::make('code');

    expect($component)->toBeInstanceOf(CodeMirror::class);
});

it('can set language', function () {
    $component = CodeMirror::make('code')
        ->language('javascript');

    expect($component->getLanguage())->toBe('javascript');
});

it('can set theme', function () {
    $component = CodeMirror::make('code')
        ->theme('dark');

    expect($component->getTheme())->toBe('dark');
});

it('can enable line numbers', function () {
    $component = CodeMirror::make('code')
        ->lineNumbers();

    expect($component->hasLineNumbers())->toBeTrue();
});

it('can disable line numbers', function () {
    $component = CodeMirror::make('code')
        ->lineNumbers(false);

    expect($component->hasLineNumbers())->toBeFalse();
});

it('can enable line wrapping', function () {
    $component = CodeMirror::make('code')
        ->lineWrapping();

    expect($component->hasLineWrapping())->toBeTrue();
});

it('can set read-only mode', function () {
    $component = CodeMirror::make('code')
        ->readOnly();

    expect($component->isReadOnly())->toBeTrue();
});

it('can set tab size', function () {
    $component = CodeMirror::make('code')
        ->tabSize(4);

    expect($component->getTabSize())->toBe(4);
});

it('can set min height', function () {
    $component = CodeMirror::make('code')
        ->minHeight(300);

    expect($component->getMinHeight())->toBe(300);
});

it('can set max height', function () {
    $component = CodeMirror::make('code')
        ->maxHeight(600);

    expect($component->getMaxHeight())->toBe(600);
});

it('can set custom configuration', function () {
    $config = ['option1' => 'value1'];
    $component = CodeMirror::make('code')
        ->configuration($config);

    expect($component->getConfiguration())->toBe($config);
});

it('returns json configuration', function () {
    $component = CodeMirror::make('code')
        ->language('javascript')
        ->theme('dark')
        ->lineNumbers()
        ->tabSize(2);

    $json = $component->getJsonConfiguration();
    $decoded = json_decode($json, true);

    expect($decoded)->toBeArray()
        ->and($decoded['language'])->toBe('javascript')
        ->and($decoded['theme'])->toBe('dark')
        ->and($decoded['lineNumbers'])->toBeTrue()
        ->and($decoded['tabSize'])->toBe(2);
});
