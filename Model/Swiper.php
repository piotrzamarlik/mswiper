<?php

namespace Piotrek\Slider\Model;

use Magento\Framework\Model\AbstractModel;
use Piotrek\Slider\Model\ResourceModel\Swiper as ResourceSwiper;

class Swiper extends AbstractModel
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceSwiper::class);
    }
}
