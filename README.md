# Markdown To EAD

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Tests](https://github.com/ottosmops/markdown-to-ead/actions/workflows/run-tests.yml/badge.svg)](https://github.com/ottosmops/markdown-to-ead/actions/workflows/run-tests.yml)


Convert Markdown Snippets to EAD 2002.

|Markdown| EAD |
|--------|-----|
|#, ##, etc | `<head>` |
| Lists     | `<list>` | 
| ListItems (*) | `<item>` |
| Links `[text](url)` | `<ref href="url">text</ref>`|
| Strong (`**bold**`) | `<emph render="bold">` |
| Emaphasis (`_italic_`) | `<emph render="italic">` |


## Installation

```bash
composer require ottosmops/markdown-to-ead
````

## Usage

```php 
use Ottosmops\MarkdownToEad\Convert;

$markdown = '# Überschrift

Paragraph _kursiv_ **fett**

- Item 1
- Item 2

Inline [Link](url).
';

$converter = new Convert();
$xml = $converter->toEad($markdown);

/**
<head>Überschrift</head><p>Paragraph <emph render="italic">kursiv</emph> <emph render="bold">fett</emph></p><list><item>Item 1</item><item>Item 2</item></list><p>Inline <ref href="url">Link</ref>.</p>
*/
```


## License

MIT. Please see the [license file](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/ottosmops/markdown-to-ead.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ottosmops/markdown-to-ead.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/ottosmops/markdown-to-ead
[link-downloads]: https://packagist.org/packages/ottosmops/markdown-to-ead
[link-author]: https://github.com/ottosmops
[link-contributors]: ../../contributors
