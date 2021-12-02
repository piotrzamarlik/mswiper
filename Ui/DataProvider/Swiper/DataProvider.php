<?php

namespace Piotrek\Slider\Ui\DataProvider\Swiper;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as MagentoDataProvider;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Piotrek\Slider\Model\ResourceModel\Swiper\CollectionFactory;

class DataProvider extends MagentoDataProvider
{
    /**
     * @var array
     */
    protected array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->collectionFactory = $collectionFactory;
    }

    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $collection = $this->collectionFactory->create();

        $items = $collection->getItems();
        if (!empty($items)) {
            foreach ($items as $swiper) {
                $this->loadedData[$swiper->getId()] = $swiper->getData();
            }
        }

        return $this->loadedData;
    }
}
