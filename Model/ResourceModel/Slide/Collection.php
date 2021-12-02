<?php

namespace Piotrek\Slider\Model\ResourceModel\Slide;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Piotrek\Slider\Model\Slide;
use Piotrek\Slider\Model\ResourceModel\Slide as ResourceSlide;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Slide::class, ResourceSlide::class);
    }
}
