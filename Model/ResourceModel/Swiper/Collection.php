<?php

namespace Piotrek\Slider\Model\ResourceModel\Swiper;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Piotrek\Slider\Model\Swiper;
use Piotrek\Slider\Model\ResourceModel\Swiper as ResourceSwiper;

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
        $this->_init(Swiper::class, ResourceSwiper::class);
    }
}
