<?php
namespace App\CommonMarkExtensions;

use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Renderer\ImageRenderer;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class LazyImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    protected $config;

    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        /** @var HtmlElement $htmlElement */
        $imageRenderer = new ImageRenderer();
        $imageRenderer->setConfiguration($this->config);
        $htmlElement = $imageRenderer->render($inline, $htmlRenderer);

        $htmlElement->setAttribute('loading', 'lazy');
        $htmlElement->setAttribute('data-src', $htmlElement->getAttribute('src'));
        $htmlElement->setAttribute('class', 'lozad');
        $htmlElement->setAttribute('src', '');

        return $htmlElement;
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
