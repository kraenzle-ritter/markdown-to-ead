<?php

namespace KraenzleRitter\MarkdownToEad\Tests;

use KraenzleRitter\MarkdownToEad\Convert;
use KraenzleRitter\MarkdownToEad\Tests\TestCase;

class MarkdownToEadTest extends TestCase
{
    public function test_simple()
    {
        $markdown = '# Hello World!';

        $converter = new Convert();
        $actual = trim($converter->toEad($markdown));
        $expected = '<p>Hello World!</p>';
        $this->assertEquals(trim((string) $expected), (string) $actual);
    }

    public function test_ordered_list()
    {
        $markdown = '53. Äbtissin';

        $converter = new Convert();
        $actual = trim($converter->toEad($markdown));
        $expected = '<p>53. Äbtissin</p>';
        $this->assertEquals(trim((string) $expected), (string) $actual);
    }

    public function test_html()
    {
        $markdown = 'bla <br> bla';

        $converter = new Convert();
        $actual = trim($converter->toEad($markdown));
        $expected = '<p>bla <br> bla</p>';
        $this->assertEquals(trim((string) $expected), (string) $actual);
    }


    public function test_links()
    {
        $markdown = 'Die Unterlagen des BPW Club Zürich bilden einen eigenen Bestand. In diesem befinden sich auch Unterlagen zum Schweizerischen Verband. [AGoF 120 Archiv Club der Zürcher Berufs- und Geschäftsfrauen](https://gosteli.anton.ch/objects/18979)';

        $converter = new Convert();
        $actual = trim($converter->toEad($markdown));
        $expected = '<p>Die Unterlagen des BPW Club Zürich bilden einen eigenen Bestand. In diesem befinden sich auch Unterlagen zum Schweizerischen Verband. <extref xlink:href="https://gosteli.anton.ch/objects/18979">AGoF 120 Archiv Club der Zürcher Berufs- und Geschäftsfrauen</extref></p>';

        $this->assertEquals(trim($expected), $actual);
    }

    public function test_list()
    {
        $markdown = 'Enthält:

- _Zeitungsartikel_
- SAFFA,
- **Schweizerische** Liga
- Vortrag';

        $converter = new Convert();
        $actual = trim($converter->toEad($markdown));
        $expected = '<p>Enthält:</p><list><item><emph render="italic">Zeitungsartikel</emph></item><item>SAFFA,</item><item><emph render="bold">Schweizerische</emph> Liga</item><item>Vortrag</item></list>';
        $this->assertEquals($expected, $actual);
    }

    public function test_combined ()
    {
        $markdown = '# Überschrift

Paragraph _kursiv_ **fett**

- Item 1
- Item 2

Inline [Link](url).
';
        $converter = new Convert();
        $actual = $converter->toEad($markdown);
        $expected = '<p>Überschrift</p><p>Paragraph <emph render="italic">kursiv</emph> <emph render="bold">fett</emph></p><list><item>Item 1</item><item>Item 2</item></list><p>Inline <extref xlink:href="url">Link</extref>.</p>';
        $this->assertEquals($expected, $actual);
    }
}
