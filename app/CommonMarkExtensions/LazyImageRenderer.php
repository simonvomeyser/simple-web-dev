<?php
namespace App\CommonMarkExtensions;

use League\CommonMark\Environment;
use League\CommonMark\HtmlElement;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class LazyImageRenderer implements InlineRendererInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * @param Image                    $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Image)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }
        
        $attrs = $inline->getData('attributes', []);
        
        if (RegexHelper::isLinkPotentiallyUnsafe($inline->getUrl())) {
            $attrs['src'] = '';
        } else {
            $attrs['src'] = $inline->getUrl();
        }


        $alt = $htmlRenderer->renderInlines($inline->children());
        $alt = \preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\<[^>]*\>/', '', $alt);
        //this should be sufficient soon
        $attrs['loading'] = 'lazy';
        //until then
        $attrs['data-src'] = $attrs['src'];
        unset($attrs['src']);
        $attrs['class'] = 'lozad';


        if (isset($inline->data['title'])) {
            $attrs['title'] = $inline->data['title'];
        }

        return new HtmlElement('img', $attrs, '', true);
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
