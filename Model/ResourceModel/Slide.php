<?php

namespace Piotrek\Slider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slide extends AbstractDb
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sliders', 'id');
    }
}
