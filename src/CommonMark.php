<?php

namespace SimplyDi\SimplyMarkdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class CommonMark
{

    protected MarkdownConverter $converter;

    public function __construct(private array $config = [])
    {
        
        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment($this->config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new FrontMatterExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $converter = new MarkdownConverter($environment);

        $this->converter = $converter;
    }

    /**
     * @throws CommonMarkException
     */
    public function convertToHtml($markdown): array
    {
        $content = $this->converter->convert($markdown);

        $output = [];

        foreach ($content->getFrontMatter() as $metaText => $metaValue)
        {
            $output[$metaText] = $metaValue;
        }

        $output['content'] = $content->getContent();

        return $output;
    }
}
