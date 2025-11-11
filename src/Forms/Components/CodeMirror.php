<?php

namespace Superscript\FilamentCodemirror\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class CodeMirror extends Field
{
    protected string $view = 'filament-codemirror::forms.components.codemirror';

    protected array $extensions = [];

    protected ?string $language = null;

    protected ?string $theme = 'default';

    protected bool $lineNumbers = true;

    protected bool $lineWrapping = false;

    protected bool $readOnly = false;

    protected ?int $tabSize = 2;

    protected ?int $minHeight = null;

    protected ?int $maxHeight = null;

    protected array $customConfiguration = [];

    /**
     * Set the CodeMirror extensions to use.
     */
    public function extensions(array|Closure $extensions): static
    {
        $this->extensions = $this->evaluate($extensions) ?? [];

        return $this;
    }

    /**
     * Get the configured extensions.
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * Set the language mode (e.g., 'javascript', 'php', 'python', 'html', 'css', 'sql', 'markdown').
     */
    public function language(string|Closure|null $language): static
    {
        $this->language = $this->evaluate($language);

        return $this;
    }

    /**
     * Get the configured language.
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * Set the theme (e.g., 'default', 'dark', 'light', or custom theme name).
     */
    public function theme(string|Closure $theme): static
    {
        $this->theme = $this->evaluate($theme);

        return $this;
    }

    /**
     * Get the configured theme.
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * Enable or disable line numbers.
     */
    public function lineNumbers(bool|Closure $condition = true): static
    {
        $this->lineNumbers = $this->evaluate($condition);

        return $this;
    }

    /**
     * Check if line numbers are enabled.
     */
    public function hasLineNumbers(): bool
    {
        return $this->lineNumbers;
    }

    /**
     * Enable or disable line wrapping.
     */
    public function lineWrapping(bool|Closure $condition = true): static
    {
        $this->lineWrapping = $this->evaluate($condition);

        return $this;
    }

    /**
     * Check if line wrapping is enabled.
     */
    public function hasLineWrapping(): bool
    {
        return $this->lineWrapping;
    }

    /**
     * Set the component to read-only mode.
     */
    public function readOnly(bool|Closure $condition = true): static
    {
        $this->readOnly = $this->evaluate($condition);

        return $this;
    }

    /**
     * Check if the component is read-only.
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * Set the tab size (spaces per tab).
     */
    public function tabSize(int|Closure $size): static
    {
        $this->tabSize = $this->evaluate($size);

        return $this;
    }

    /**
     * Get the configured tab size.
     */
    public function getTabSize(): ?int
    {
        return $this->tabSize;
    }

    /**
     * Set the minimum height in pixels.
     */
    public function minHeight(int|Closure $height): static
    {
        $this->minHeight = $this->evaluate($height);

        return $this;
    }

    /**
     * Get the minimum height.
     */
    public function getMinHeight(): ?int
    {
        return $this->minHeight;
    }

    /**
     * Set the maximum height in pixels.
     */
    public function maxHeight(int|Closure $height): static
    {
        $this->maxHeight = $this->evaluate($height);

        return $this;
    }

    /**
     * Get the maximum height.
     */
    public function getMaxHeight(): ?int
    {
        return $this->maxHeight;
    }

    /**
     * Set custom CodeMirror configuration options.
     */
    public function configuration(array|Closure $config): static
    {
        $this->customConfiguration = $this->evaluate($config) ?? [];

        return $this;
    }

    /**
     * Get the custom configuration.
     */
    public function getConfiguration(): array
    {
        return $this->customConfiguration;
    }

    /**
     * Get the complete configuration array for the frontend.
     */
    public function getJsonConfiguration(): string
    {
        $config = [
            'language' => $this->getLanguage(),
            'theme' => $this->getTheme(),
            'lineNumbers' => $this->hasLineNumbers(),
            'lineWrapping' => $this->hasLineWrapping(),
            'readOnly' => $this->isReadOnly(),
            'tabSize' => $this->getTabSize(),
            'minHeight' => $this->getMinHeight(),
            'maxHeight' => $this->getMaxHeight(),
            'extensions' => $this->getExtensions(),
            'customConfiguration' => $this->getConfiguration(),
        ];

        return json_encode($config, JSON_THROW_ON_ERROR);
    }
}
