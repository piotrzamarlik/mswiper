<?php

namespace Piotrek\Slider\Test\Unit\ViewModel;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Piotrek\Slider\Model\ResourceModel\Slide\Collection;
use Piotrek\Slider\Model\ResourceModel\Slide\CollectionFactory;
use PHPUnit\Framework\TestCase;
use Piotrek\Slider\ViewModel\Slider;

class SliderTest extends TestCase
{
    /**
     * @var StoreManagerInterface $storeManager
     */
    private StoreManagerInterface $storeManager;

    private Slider $slider;

    /**
     * @var CollectionFactory $collectionFactory
     */
    private CollectionFactory $collectionFactory;

    public function setUp(): void
    {
        $this->collectionFactory = $this->createPartialMock(
            CollectionFactory::class,
            ['create']
        );

        $this->storeManager = $this->createMock(StoreManagerInterface::class);

        $this->slider = new Slider(
            $this->collectionFactory,
            $this->storeManager
        );
    }

    /**
     * Run test toOptionArray method
     *
     * @return void
     */
    public function testGetSliders()
    {
        $sliderCollectionMock = $this->createMock(Collection::class);

        $this->collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($sliderCollectionMock);

        $sliderCollectionMock->expects($this->any())
            ->method('addFieldToFilter')
            ->with('is_active', 1)
            ->willReturnSelf();

        $result = $this->slider->getSliders();
        $this->assertTrue($result instanceof Collection);
    }
}
