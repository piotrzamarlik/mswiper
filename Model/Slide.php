<?php

namespace Piotrek\Slider\Model;

use Magento\Framework\Model\AbstractModel;
use Piotrek\Slider\Model\ResourceModel\Slide as ResourceSlide;

class Slide extends AbstractModel
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceSlide::class);
    }
}
