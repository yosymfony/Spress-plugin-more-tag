<?php

namespace SpressPlugins\SpressMoreTag;

use Symfony\Component\EventDispatcher\Event;
use Yosymfony\Spress\Plugin\Plugin;
use Yosymfony\Spress\Plugin\EventSubscriber;
use Yosymfony\Spress\Plugin\Event\RenderEvent;
use Yosymfony\Spress\Plugin\Event\ConvertEvent;

class SpressMoreTag extends Plugin
{
    const LABEL_DEFAULT = 'more';
    
    private $patternsHtml = "/(<p>)?(--more--)|(--more (.*?)--)(<\/p>)?\n/m";
    
    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.before_render', 'onBeforeRender');
        $subscriber->addEventListener('spress.before_render_pagination', 'onBeforeRenderPagination');
    }
    
    public function onBeforeRender(RenderEvent $event)
    {
        $label = self::LABEL_DEFAULT;
        $payload = $event->getPayload();
        $content = $event->getContent();
        
        if(false == $event->isPost())
        {
            return;
        }
        
        if(false == preg_match($this->patternsHtml, $content, $matches))
        {
            return;
        }
        
        if(isset($matches[4]))
        {
            $label = $matches[4];
        }
        
        $result = preg_split($this->patternsHtml, $content, 2);
        $payload['page']['excerpt'] = $result[0];
        $payload['page']['excerpt_label'] = $label;
        
        $event->setContent(preg_replace($this->patternsHtml, '', $content));
        $event->setPayload($payload);
    }
    
    public function onBeforeRenderPagination(RenderEvent $event)
    {
        $payload = $event->getPayload();
        
        foreach($payload['paginator']['posts'] as $index => $postPage)
        {
            if(preg_match($this->patternsHtml, $postPage['content'], $matches))
            {
                $label = self::LABEL_DEFAULT;
                
                if(isset($matches[4]))
                {
                    $label = $matches[4];
                }
                
                $result = preg_split($this->patternsHtml,  $postPage['content'], 2);
                $payload['paginator']['posts'][$index]['excerpt'] = $result[0];
                $payload['paginator']['posts'][$index]['excerpt_label'] = $label;
                
                $event->setPayload($payload);
            }
        }
    }
}