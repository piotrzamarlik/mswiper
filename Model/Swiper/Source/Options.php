<?php

namespace Piotrek\Slider\Model\Swiper\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Piotrek\Slider\Model\ResourceModel\Swiper\CollectionFactory;

class Options implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @var CollectionFactory $swiperCollectionFactory
     */
    protected CollectionFactory $swiperCollectionFactory;

    public function __construct(
        CollectionFactory $swiperCollectionFactory
    ) {
        $this->swiperCollectionFactory = $swiperCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->swiperCollectionFactory->create();
        $options = [
            [
                'value' => null,
                'label' => __('-- Please Select --')
            ]
        ];

        return array_merge($options, $collection->toOptionArray());
    }
}
