<?php

namespace SpressPlugins\SpressMoreTag;

use Symfony\Component\EventDispatcher\Event;
use Yosymfony\Spress\Plugin\Plugin;
use Yosymfony\Spress\Plugin\EventSubscriber;
use Yosymfony\Spress\Plugin\Event\EnviromentEvent;
use Yosymfony\Spress\Plugin\Event\RenderEvent;
use Yosymfony\Spress\Plugin\Event\ConvertEvent;

class SpressMoreTag extends Plugin
{
    const LABEL_DEFAULT = 'more';
    
    private $patternsHtml = "/(<p>)?(--more--)|(--more (.*?)--)(<\/p>)?\n/m";
    private $postsExcerpt = [];
    private $configRepository;
    
    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.start', 'onStart');
        $subscriber->addEventListener('spress.after_render', 'onAfterRender');
        $subscriber->addEventListener('spress.before_render_pagination', 'onBeforeRenderPagination');
    }
    
    public function onStart(EnviromentEvent $event)
    {
        $this->configRepository = $event->getConfigRepository();
    }
    
    public function onAfterRender(RenderEvent $event)
    {
        $label = self::LABEL_DEFAULT;
        $payload = $event->getPayload();
        $content = $event->getContent();
        $payloadContent = $payload['page']['content'];
        
        if(false == $event->isPost())
        {
            return;
        }
        
        if(false == preg_match($this->patternsHtml, $payloadContent, $matches))
        {
            return;
        }
        
        if(isset($matches[4]))
        {
            $label = $matches[4];
        }
        
        $result = preg_split($this->patternsHtml, $payloadContent, 2);
        $this->postsExcerpt[$event->getId()] = ['value' => rtrim($result[0], '<p>'), 'label' => $label];
        $this->configRepository['posts_excerpts'] = $this->postsExcerpt;
        
        $event->setContent(preg_replace($this->patternsHtml, '', $content));
    }
    
    public function onBeforeRenderPagination(RenderEvent $event)
    {
        $payload = $event->getPayload();
        
        foreach($payload['paginator']['posts'] as $index => $postPage)
        {
            $postId = $postPage['id'];
            $excerpt = isset($this->postsExcerpt[$postId]) ? $this->postsExcerpt[$postId] : null;
            
            if($excerpt)
            {
                $payload['paginator']['posts'][$index]['excerpt'] = $excerpt['value'];
                $payload['paginator']['posts'][$index]['excerpt_label'] = $excerpt['label'];
                
                $event->setPayload($payload);
            }
        }
    }
}