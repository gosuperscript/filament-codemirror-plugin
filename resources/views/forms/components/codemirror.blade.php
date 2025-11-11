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
                if (!lang) return null;
                
                try {
                    // Normalize language name
                    const langMap = {
                        'js': 'javascript',
                        'ts': 'typescript',
                        'md': 'markdown',
                    };
                    
                    const normalizedLang = langMap[lang] || lang;
                    
                    // Handle TypeScript as a special case of JavaScript
                    if (normalizedLang === 'typescript') {
                        const { javascript } = await import('https://cdn.jsdelivr.net/npm/@codemirror/lang-javascript@6.0.0/+esm');
                        return javascript({ typescript: true });
                    }
                    
                    // Dynamically import the language package
                    const packageUrl = `https://cdn.jsdelivr.net/npm/@codemirror/lang-${normalizedLang}@6.0.0/+esm`;
                    const module = await import(packageUrl);
                    
                    // Get the language function (usually the same name as the package)
                    const langFunction = module[normalizedLang];
                    
                    if (typeof langFunction === 'function') {
                        return langFunction();
                    }
                    
                    console.warn(`Language function not found for: ${normalizedLang}`);
                    return null;
                } catch (error) {
                    console.error(`Error loading language support for '${lang}':`, error);
                    return null;
                }
            },
            
            async loadTheme(themeName) {
                if (!themeName || themeName === 'default') return null;
                
                try {
                    // Map common theme names
                    const themeMap = {
                        'dark': 'theme-one-dark',
                        'oneDark': 'theme-one-dark',
                        'oneLight': 'theme-one-light',
                        'light': 'theme-one-light',
                    };
                    
                    const themePackage = themeMap[themeName] || themeName;
                    
                    // Dynamically import the theme package
                    const packageUrl = `https://cdn.jsdelivr.net/npm/@codemirror/${themePackage}@6.0.0/+esm`;
                    const module = await import(packageUrl);
                    
                    // For oneDark theme
                    if (module.oneDark) {
                        return module.oneDark;
                    }
                    
                    // For other themes, try to find the main export
                    const themeExport = Object.values(module).find(exp => 
                        exp && typeof exp === 'object' && exp.extension
                    );
                    
                    if (themeExport) {
                        return themeExport;
                    }
                    
                    console.warn(`Theme not found in module: ${themeName}`);
                    return null;
                } catch (error) {
                    console.error(`Error loading theme '${themeName}':`, error);
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
