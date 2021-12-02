<?php

namespace Piotrek\Slider\Block\Adminhtml\Swipers\Edit\Button;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Abstract Slide button
 *
 * @package  Piotrek\Slider
 */
class AbstractButton implements ButtonProviderInterface
{
    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * Generic constructor
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route The route
     * @param array $params The params
     *
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getButtonData(): array
    {
        return [];
    }
}
