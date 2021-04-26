<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Block;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Testimonials Block
 * @package Overdose\Testimonials\Block
 */
class Testimonials extends Template
{

    /**
     * @var array
     */
    protected $layoutProcessors;

    /**
     * @var Json
     */
    private $serializer;

    public function __construct(
        Context $context,
        array $data = [],
        array $layoutProcessors = [],
        Json $serializer = null
    ) {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
        $this->serializer = $serializer ?: ObjectManager::getInstance()
            ->get(Json::class);
    }

    /**
     * @return string
     */
    public function getJsLayout(): string
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }

        return $this->serializer->serialize($this->jsLayout);
    }
}
