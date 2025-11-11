<?php

use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Event;
use Livewire\Component as LivewireComponent;
use Superscript\FilamentCodemirror\Forms\Components\CodeMirror;

it('can be used in a form schema', function () {
    $form = Form::make(new class extends LivewireComponent
    {
        public $data = [];

        public function form(Form $form): Form
        {
            return $form
                ->schema([
                    CodeMirror::make('code')
                        ->language('javascript'),
                ])
                ->statePath('data');
        }
    })
        ->schema([
            CodeMirror::make('code')
                ->language('javascript'),
        ]);

    expect($form->getComponents())->toHaveCount(1)
        ->and($form->getComponents()[0])->toBeInstanceOf(CodeMirror::class);
});

it('can be used in a complex form schema with other components', function () {
    $schema = [
        Section::make('Code Editor')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Select::make('language')
                    ->options([
                        'javascript' => 'JavaScript',
                        'python' => 'Python',
                        'php' => 'PHP',
                    ])
                    ->required()
                    ->reactive(),

                CodeMirror::make('code')
                    ->language(fn ($get) => $get('language') ?? 'javascript')
                    ->lineNumbers()
                    ->lineWrapping()
                    ->minHeight(400)
                    ->maxHeight(800)
                    ->required(),
            ]),
    ];

    $form = Form::make(new class extends LivewireComponent
    {
        public $data = [];
    })
        ->schema($schema)
        ->statePath('data');

    expect($form->getComponents())->toHaveCount(1);

    $section = $form->getComponents()[0];
    expect($section)->toBeInstanceOf(Section::class);

    $childComponents = $section->getChildComponents();
    expect($childComponents)->toHaveCount(3);

    expect($childComponents[0])->toBeInstanceOf(TextInput::class)
        ->and($childComponents[1])->toBeInstanceOf(Select::class)
        ->and($childComponents[2])->toBeInstanceOf(CodeMirror::class);
});

it('can handle reactive language switching in a form', function () {
    $component = CodeMirror::make('code')
        ->language(fn ($get) => $get('language') ?? 'javascript');

    expect($component)->toBeInstanceOf(CodeMirror::class);
});

it('can be configured with all options in a form schema', function () {
    $component = CodeMirror::make('code')
        ->label('Source Code')
        ->language('python')
        ->theme('dark')
        ->lineNumbers()
        ->lineWrapping()
        ->tabSize(4)
        ->minHeight(300)
        ->maxHeight(600)
        ->readOnly(false)
        ->required()
        ->helperText('Enter your Python code here');

    expect($component)->toBeInstanceOf(CodeMirror::class)
        ->and($component->getLanguage())->toBe('python')
        ->and($component->getTheme())->toBe('dark')
        ->and($component->hasLineNumbers())->toBeTrue()
        ->and($component->hasLineWrapping())->toBeTrue()
        ->and($component->getTabSize())->toBe(4)
        ->and($component->getMinHeight())->toBe(300)
        ->and($component->getMaxHeight())->toBe(600)
        ->and($component->isReadOnly())->toBeFalse();
});

it('can render view with state path', function () {
    $component = CodeMirror::make('code')
        ->language('javascript');

    expect($component->getView())->toBe('filament-codemirror::forms.components.codemirror');
});

it('generates proper json configuration for frontend in a form context', function () {
    $component = CodeMirror::make('code')
        ->language('javascript')
        ->theme('dark')
        ->lineNumbers()
        ->lineWrapping()
        ->tabSize(2)
        ->minHeight(200)
        ->maxHeight(800);

    $json = $component->getJsonConfiguration();
    $decoded = json_decode($json, true);

    expect($decoded)->toBeArray()
        ->and($decoded)->toHaveKey('language')
        ->and($decoded)->toHaveKey('theme')
        ->and($decoded)->toHaveKey('lineNumbers')
        ->and($decoded)->toHaveKey('lineWrapping')
        ->and($decoded)->toHaveKey('tabSize')
        ->and($decoded)->toHaveKey('minHeight')
        ->and($decoded)->toHaveKey('maxHeight')
        ->and($decoded['language'])->toBe('javascript')
        ->and($decoded['theme'])->toBe('dark')
        ->and($decoded['lineNumbers'])->toBeTrue()
        ->and($decoded['lineWrapping'])->toBeTrue()
        ->and($decoded['tabSize'])->toBe(2)
        ->and($decoded['minHeight'])->toBe(200)
        ->and($decoded['maxHeight'])->toBe(800);
});
