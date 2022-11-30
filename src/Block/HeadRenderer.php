<?php

namespace KraenzleRitter\MarkdownToEad\Block;

use League\CommonMark\Node\Node;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;

class HeadRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Heading::assertInstanceOf($node);

        $tag = 'head';

        $attrs = []; //'level' => (string) $node->getLevel()

        return new HtmlElement($tag, $attrs, $childRenderer->renderNodes($node->children()));
    }
}
