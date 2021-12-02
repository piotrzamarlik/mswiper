<?php

namespace Piotrek\Slider\ViewModel;

use Piotrek\Slider\Model\ResourceModel\Slide\Collection;
use Piotrek\Slider\Model\Slide;
use Piotrek\Slider\Model\Swiper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Piotrek\Slider\Model\ResourceModel\Slide\CollectionFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Piotrek\Slider\Model\ResourceModel\Swiper\CollectionFactory as SwiperCollection;

class Slider implements ArgumentInterface
{
    protected SwiperCollection $swiperCollection;
    /**
     * @var StoreManagerInterface $storeManager ;
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var CollectionFactory $collectionFactory ;
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        SwiperCollection $swiperCollection,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->swiperCollection = $swiperCollection;
    }

    /**
     * @param Swiper $swiperId
     *
     * @return Collection
     */
    public function getSliders($swiperId): Collection
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter('is_active', 1)
            ->addFilter('swiper_id', $swiperId);
    }


    public function getSwiper($swiperId)
    {
        return $this->swiperCollection->create()->getItemById($swiperId);
    }

    /**
     * @param Slide $slide
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getUrl(Slide $slide): string
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl . $slide->getImagePath();
    }
}
