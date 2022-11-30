<?php

namespace Ottosmops\MarkdownToEad;

use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use Ottosmops\MarkdownToEad\Block\HeadRenderer;
use Ottosmops\MarkdownToEad\Inline\LinkRenderer;
use Ottosmops\MarkdownToEad\Inline\StrongRenderer;
use Ottosmops\MarkdownToEad\Block\ListItemRenderer;
use Ottosmops\MarkdownToEad\Block\ListBlockRenderer;
use Ottosmops\MarkdownToEad\Inline\EmphasisRenderer;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

class Convert
{
    public function __construct()
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addRenderer(Heading::class, new HeadRenderer());
        $environment->addRenderer(Link::class, new LinkRenderer());
        $environment->addRenderer(ListBlock::class, new ListBlockRenderer());
        $environment->addRenderer(ListItem::class, new ListItemRenderer());
        $environment->addRenderer(Emphasis::class, new EmphasisRenderer());
        $environment->addRenderer(Strong::class, new StrongRenderer());

        $this->converter = new MarkdownConverter($environment);

    }
    public function toEad($string, $newlines = false)
    {
        $xml = $this->converter->convert($string)->getContent();

        if ($newlines) {
            return $xml;
        }
        return  trim(str_replace("\n", "", $xml));
    }


}
