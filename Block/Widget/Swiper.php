<?php

namespace Piotrek\Slider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Piotrek\Slider\ViewModel\Slider;

class Swiper extends Template implements BlockInterface
{
    /**
     * @var Slider $viewModel
     */
    protected Slider $viewModel;

    /**
     * @var string $_template
     */
    protected $_template = 'widget/slider.phtml';

    /**
     * @param Slider $viewModel
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Slider $viewModel,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->viewModel = $viewModel;
    }

    /**
     * @return Slider
     */
    public function getViewModel(): Slider
    {
        return $this->viewModel;
    }
}
