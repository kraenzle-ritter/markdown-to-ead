<?php

namespace KraenzleRitter\MarkdownToEad;

use KraenzleRitter\MarkdownToEad\Parser\ListBlockStartParser;
use Nette\Schema\Expect;
use League\CommonMark\Node as CoreNode;
use League\CommonMark\Parser as CoreParser;
use League\CommonMark\Renderer as CoreRenderer;
use League\Config\ConfigurationBuilderInterface;
use League\CommonMark\Renderer\Inline\TextRenderer;
use League\CommonMark\Renderer\Block\DocumentRenderer;
use League\CommonMark\Renderer\Inline\NewlineRenderer;
use League\CommonMark\Renderer\Block\ParagraphRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BangParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\EntityParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\AutolinkParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BacktickParser;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\CodeRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\LinkRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Inline\EscapableParser;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\ImageRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Inline\HtmlInlineParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HeadingRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\StrongRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Block\HeadingStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\OpenBracketParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ListItemRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Inline\CloseBracketParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HtmlBlockRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ListBlockRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\EmphasisRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Block\HtmlBlockStartParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\BlockQuoteRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Block\BlockQuoteStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\FencedCodeStartParser;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\HtmlInlineRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\IndentedCodeRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Block\IndentedCodeStartParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ThematicBreakRenderer;
use League\CommonMark\Extension\CommonMark\Parser\Block\ThematicBreakStartParser;
use League\CommonMark\Extension\CommonMark\Delimiter\Processor\EmphasisDelimiterProcessor;

final class MarkdownToEadExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('commonmark', Expect::structure([
            'use_asterisk' => Expect::bool(true),
            'use_underscore' => Expect::bool(true),
            'enable_strong' => Expect::bool(true),
            'enable_em' => Expect::bool(true),
            'unordered_list_markers' => Expect::listOf('string')->min(1)->default(['*', '+', '-'])->mergeDefaults(false),
        ]));
    }

    // phpcs:disable Generic.Functions.FunctionCallArgumentSpacing.TooMuchSpaceAfterComma,Squiz.WhiteSpace.SemicolonSpacing.Incorrect
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            //->addBlockStartParser(new BlockQuoteStartParser(),     70)
            ->addBlockStartParser(new HeadingStartParser(),        60)
            //->addBlockStartParser(new FencedCodeStartParser(),     50)
            ->addBlockStartParser(new HtmlBlockStartParser(),      40)
            ->addBlockStartParser(new ThematicBreakStartParser(),  20)
            ->addBlockStartParser(new ListBlockStartParser(),      10)
            //->addBlockStartParser(new IndentedCodeStartParser(), -100)

            ->addInlineParser(new CoreParser\Inline\NewlineParser(), 200)
            ->addInlineParser(new BacktickParser(),    150)
            ->addInlineParser(new EscapableParser(),    80)
            ->addInlineParser(new EntityParser(),       70)
            ->addInlineParser(new AutolinkParser(),     50)
            ->addInlineParser(new HtmlInlineParser(),   40)
            ->addInlineParser(new CloseBracketParser(), 30)
            ->addInlineParser(new OpenBracketParser(),  20)
            ->addInlineParser(new BangParser(),         10)

            //->addRenderer(Node\Block\BlockQuote::class,    new BlockQuoteRenderer(),    0)
            ->addRenderer(CoreNode\Block\Document::class,  new DocumentRenderer(),  0)
            //->addRenderer(Node\Block\FencedCode::class,    new FencedCodeRenderer(),    0)
            ->addRenderer(Node\Block\Heading::class,       new HeadingRenderer(),       0)
            //->addRenderer(Node\Block\HtmlBlock::class,     new HtmlBlockRenderer(),     0)
            ->addRenderer(Node\Block\IndentedCode::class,  new IndentedCodeRenderer(),  0)
            ->addRenderer(Node\Block\ListBlock::class,     new ListBlockRenderer(),     0)
            ->addRenderer(Node\Block\ListItem::class,      new ListItemRenderer(),      0)
            ->addRenderer(CoreNode\Block\Paragraph::class, new ParagraphRenderer(), 0)
            ->addRenderer(Node\Block\ThematicBreak::class, new ThematicBreakRenderer(), 0)

            ->addRenderer(Node\Inline\Code::class,        new CodeRenderer(),        0)
            ->addRenderer(Node\Inline\Emphasis::class,    new EmphasisRenderer(),    0)
            ->addRenderer(Node\Inline\HtmlInline::class,  new HtmlInlineRenderer(),  0)
            ->addRenderer(Node\Inline\Image::class,       new ImageRenderer(),       0)
            ->addRenderer(Node\Inline\Link::class,        new LinkRenderer(),        0)
            ->addRenderer(CoreNode\Inline\Newline::class, new NewlineRenderer(), 0)
            ->addRenderer(Node\Inline\Strong::class,      new StrongRenderer(),      0)
            ->addRenderer(CoreNode\Inline\Text::class,    new TextRenderer(),    0)
        ;

        if ($environment->getConfiguration()->get('commonmark/use_asterisk')) {
            $environment->addDelimiterProcessor(new EmphasisDelimiterProcessor('*'));
        }

        if ($environment->getConfiguration()->get('commonmark/use_underscore')) {
            $environment->addDelimiterProcessor(new EmphasisDelimiterProcessor('_'));
        }
    }
}
