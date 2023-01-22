# Markdown To EAD

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Tests](https://github.com/kraenzle-ritter/markdown-to-ead/actions/workflows/run-tests.yml/badge.svg)](https://github.com/kraenzle-ritter/markdown-to-ead/actions/workflows/run-tests.yml)


**Don´t use this package. It has a very special pupose within anton (anton.ch).**

Convert Markdown Snippets to EAD 2002.

|Markdown| EAD |
|--------|-----|
|#, ##, etc | `<p>` (since ead does not allow titles, heads within the fields |
| Lists     | `<list>` | 
| ListItems (*) | `<item>` |
| Links `[text](url)` | `<extref xlink:href="url">text</extref>`|
| Strong (`**bold**`) | `<emph render="bold">` |
| Emaphasis (`_italic_`) | `<emph render="italic">` |


## Installation

```bash
composer require kraenzle-ritter/markdown-to-ead
````

## Usage

```php 
use KraenzleRitter\MarkdownToEad\Convert;

$markdown = '# Überschrift

Paragraph _kursiv_ **fett**

- Item 1
- Item 2

Inline [Link](url).
';

$converter = new Convert();
$xml = $converter->toEad($markdown);

/**
<head>Überschrift</head><p>Paragraph <emph render="italic">kursiv</emph> <emph render="bold">fett</emph></p><list><item>Item 1</item><item>Item 2</item></list><p>Inline <extref xlink:href="url">Link</extref>.</p>
*/
```


## License

MIT. Please see the [license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/kraenzle-ritter/markdown-to-ead.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kraenzle-ritter/markdown-to-ead.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/kraenzle-ritter/markdown-to-ead
[link-downloads]: https://packagist.org/packages/kraenzle-ritter/markdown-to-ead
[link-author]: https://github.com/kraenzle-ritter
[link-contributors]: ../../contributors
