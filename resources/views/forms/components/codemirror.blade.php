@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $configuration = $getJsonConfiguration();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            editor: null,
            config: {{ $configuration }},
            
            init() {
                this.initializeEditor();
            },
            
            async initializeEditor() {
                // Import CodeMirror modules
                const { EditorView, basicSetup } = await import('https://cdn.jsdelivr.net/npm/codemirror@6.0.1/+esm');
                const { EditorState } = await import('https://cdn.jsdelivr.net/npm/@codemirror/state@6.0.0/+esm');
                
                let extensions = [basicSetup];
                
                // Add language support
                if (this.config.language) {
                    const langModule = await this.loadLanguage(this.config.language);
                    if (langModule) {
                        extensions.push(langModule);
                    }
                }
                
                // Add theme
                if (this.config.theme && this.config.theme !== 'default') {
                    const themeModule = await this.loadTheme(this.config.theme);
                    if (themeModule) {
                        extensions.push(themeModule);
                    }
                }
                
                // Add read-only support
                if (this.config.readOnly || {{ $isDisabled ? 'true' : 'false' }}) {
                    const { EditorState } = await import('https://cdn.jsdelivr.net/npm/@codemirror/state@6.0.0/+esm');
                    extensions.push(EditorState.readOnly.of(true));
                }
                
                // Add line wrapping
                if (this.config.lineWrapping) {
                    const { EditorView } = await import('https://cdn.jsdelivr.net/npm/codemirror@6.0.1/+esm');
                    extensions.push(EditorView.lineWrapping);
                }
                
                // Create the editor
                const startState = EditorState.create({
                    doc: this.state || '',
                    extensions: [
                        ...extensions,
                        EditorView.updateListener.of((update) => {
                            if (update.docChanged) {
                                this.state = update.state.doc.toString();
                            }
                        })
                    ]
                });
                
                this.editor = new EditorView({
                    state: startState,
                    parent: this.$refs.editorContainer
                });
                
                // Apply height constraints
                if (this.config.minHeight || this.config.maxHeight) {
                    const style = this.$refs.editorContainer.querySelector('.cm-editor').style;
                    if (this.config.minHeight) {
                        style.minHeight = this.config.minHeight + 'px';
                    }
                    if (this.config.maxHeight) {
                        style.maxHeight = this.config.maxHeight + 'px';
                    }
                }
            },
            
            async loadLanguage(lang) {
                try {
                    switch(lang) {
                        case 'javascript':
                        case 'js':
                            const { javascript } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-javascript@6.0.0/+esm');
                            return javascript();
                        case 'typescript':
                        case 'ts':
                            const { javascript: jsForTs } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-javascript@6.0.0/+esm');
                            return jsForTs({ typescript: true });
                        case 'python':
                            const { python } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-python@6.0.0/+esm');
                            return python();
                        case 'html':
                            const { html } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-html@6.0.0/+esm');
                            return html();
                        case 'css':
                            const { css } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-css@6.0.0/+esm');
                            return css();
                        case 'json':
                            const { json } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-json@6.0.0/+esm');
                            return json();
                        case 'markdown':
                        case 'md':
                            const { markdown } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-markdown@6.0.0/+esm');
                            return markdown();
                        case 'xml':
                            const { xml } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-xml@6.0.0/+esm');
                            return xml();
                        case 'sql':
                            const { sql } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-sql@6.0.0/+esm');
                            return sql();
                        case 'php':
                            const { php } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-php@6.0.0/+esm');
                            return php();
                        default:
                            return null;
                    }
                } catch (error) {
                    console.error('Error loading language support:', error);
                    return null;
                }
            },
            
            async loadTheme(themeName) {
                try {
                    switch(themeName) {
                        case 'dark':
                            const { oneDark } = await import('https://cdn.jsdelivr.net/npm/@codemirror/theme-one-dark@6.0.0/+esm');
                            return oneDark;
                        default:
                            return null;
                    }
                } catch (error) {
                    console.error('Error loading theme:', error);
                    return null;
                }
            }
        }"
        wire:ignore
    >
        <div 
            x-ref="editorContainer"
            class="filament-codemirror-editor border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden"
        ></div>
    </div>
</x-dynamic-component>
