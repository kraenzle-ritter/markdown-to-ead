<?php

namespace KraenzleRitter\MarkdownToEad;


use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use KraenzleRitter\MarkdownToEad\Block\HeadRenderer;
use KraenzleRitter\MarkdownToEad\Inline\LinkRenderer;
use KraenzleRitter\MarkdownToEad\Inline\StrongRenderer;
use KraenzleRitter\MarkdownToEad\Block\ListItemRenderer;
use KraenzleRitter\MarkdownToEad\MarkdownToEadExtension;
use KraenzleRitter\MarkdownToEad\Block\ListBlockRenderer;
use KraenzleRitter\MarkdownToEad\Inline\EmphasisRenderer;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\HtmlInlineRenderer;

class Convert
{
    public function __construct()
    {
        $environment = new Environment();
        $environment->addExtension(new MarkdownToEadExtension());
        $environment->addRenderer(Heading::class, new HeadRenderer());
        $environment->addRenderer(Link::class, new LinkRenderer());
        $environment->addRenderer(ListBlock::class, new ListBlockRenderer());
        $environment->addRenderer(ListItem::class, new ListItemRenderer());
        $environment->addRenderer(Emphasis::class, new EmphasisRenderer());
        $environment->addRenderer(Strong::class, new StrongRenderer());
        $environment->addRenderer(HtmlInline::class,  new HtmlInlineRenderer());
        $this->converter = new MarkdownConverter($environment);

    }
    public function toEad($string, $newlines = false)
    {
        $xml = $this->converter->convert($string)->getContent();

        if ($newlines) {
            return $xml;
        }
        return  trim(str_replace(["\n", "<br/>"], "", $xml));
    }


}
