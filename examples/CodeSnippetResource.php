<?php

namespace App\Filament\Resources;

use App\Models\CodeSnippet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Superscript\FilamentCodemirror\Forms\Components\CodeMirror;

class CodeSnippetResource extends Resource
{
    protected static ?string $model = CodeSnippet::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Snippet Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., User Authentication Function'),

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
                            ->default('javascript')
                            ->reactive(),

                        Forms\Components\Toggle::make('is_public')
                            ->label('Public')
                            ->default(false),

                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->placeholder('Brief description of the snippet'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Code')
                    ->schema([
                        CodeMirror::make('code')
                            ->label('Code')
                            ->language(fn ($get) => $get('language') ?? 'javascript')
                            ->lineNumbers()
                            ->lineWrapping()
                            ->minHeight(400)
                            ->maxHeight(800)
                            ->required()
                            ->helperText('Write or paste your code here'),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TagsInput::make('tags')
                            ->placeholder('Add tags')
                            ->suggestions(['api', 'authentication', 'database', 'utility']),

                        Forms\Components\Select::make('category')
                            ->options([
                                'function' => 'Function',
                                'class' => 'Class',
                                'component' => 'Component',
                                'snippet' => 'Snippet',
                                'module' => 'Module',
                            ])
                            ->default('snippet'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('language')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('language')
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
                    ]),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Public'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCodeSnippets::route('/'),
            'create' => Pages\CreateCodeSnippet::route('/create'),
            'edit' => Pages\EditCodeSnippet::route('/{record}/edit'),
        ];
    }
}
