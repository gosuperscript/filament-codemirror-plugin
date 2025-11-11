# Changelog

All notable changes to `filament-codemirror-plugin` will be documented in this file.

## v1.0.0 - 2024-11-11

### Added
- Initial release of Filament CodeMirror Plugin
- CodeMirror form component for Filament v4
- Dynamic language loading supporting all CodeMirror 6 language packages:
  - JavaScript/TypeScript
  - Python, PHP, Java, C++, Rust, Go, Ruby
  - HTML/CSS/XML
  - JSON, YAML, TOML
  - SQL
  - Markdown
  - And many more...
- Dynamic theme loading supporting all CodeMirror 6 themes
- Configurable editor options:
  - Line numbers toggle
  - Line wrapping toggle
  - Read-only mode
  - Custom tab size
  - Min/max height constraints
- Custom extensions support
- Comprehensive test suite with Pest
- PHPStan static analysis
- GitHub Actions CI/CD pipeline
- Complete documentation with usage examples
- Example Filament Resource implementation
- Service provider with config file publishing

### Changed
- Namespace changed from `Gosuperscript` to `Superscript`
- Updated to support Filament 4.x (stable release)
- Minimum PHP version requirement updated to 8.4
- Made language and theme loading fully dynamic instead of hardcoded switch statements
- CI/CD pipeline updated to test on PHP 8.4 only
