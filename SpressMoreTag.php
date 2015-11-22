<?php

namespace SpressPlugins\SpressMoreTag;

use Yosymfony\Spress\Core\Plugin\PluginInterface;
use Yosymfony\Spress\Core\Plugin\EventSubscriber;
use Yosymfony\Spress\Core\Plugin\Event\EnvironmentEvent;

class SpressMoreTag implements PluginInterface
{
    const LABEL_DEFAULT = 'more';

    private $patternsHtml = "/(<p>)?(--more--)|(--more (.*?)--)(<\/p>)?\n/m";

    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.start', 'onStart');
    }

    public function getMetas()
    {
        return [
            'name' => 'yosymfony/spress-plugin-more-tag',
            'description' => 'Gets the excerpt of your content',
            'author' => 'Victor Puertas',
            'license' => 'MIT',
        ];
    }

    public function onStart(EnvironmentEvent $event)
    {
        $renderizer = $event->getRenderizer();

        $renderizer->addTwigFilter('excerpt', function ($text) {
            return $this->getExcerpt($text);
        });

        $renderizer->addTwigFilter('content', function ($text) {
            return $this->getContentWithoutExcerptLabel($text);
        });

        $renderizer->addTwigFilter('excerpt_label', function ($text) {
            return $this->getExcerptLabel($text);
        });

        $renderizer->addTwigTest('with_excerpt', function ($text) {
            return $this->hasExcerpt($text);
        });
    }

    public function getExcerpt($text)
    {
        if (false == preg_match($this->patternsHtml, $text, $matches)) {
            return $text;
        }

        $result = preg_split($this->patternsHtml, $text, 2);

        return rtrim($result[0], '<p>');
    }

    public function getContentWithoutExcerptLabel($text)
    {
        return preg_replace($this->patternsHtml, '', $text);
    }

    public function getExcerptLabel($text)
    {
        if (false == preg_match($this->patternsHtml, $text, $matches)) {
            return self::LABEL_DEFAULT;
        }

        if (isset($matches[4])) {
            return $matches[4];
        }
    }

    public function hasExcerpt($text)
    {
        if (false == preg_match($this->patternsHtml, $text)) {
            return false;
        }

        return true;
    }
}
