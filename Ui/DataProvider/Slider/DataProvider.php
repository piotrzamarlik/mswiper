<?php

namespace Piotrek\Slider\Ui\DataProvider\Slider;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as MagentoDataProvider;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Piotrek\Slider\Model\ResourceModel\Slide\CollectionFactory;

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
    ) {
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
        foreach ($items as $slide) {
            $url = $slide->getImagePath();
            $split = explode(DIRECTORY_SEPARATOR, $url);
            $name = array_pop($split);
            $this->loadedData[$slide->getId()] = $slide->getData();
            if ($url && $name) {
                $image['image'][0]['type'] = 'image';
                $image['image'][0]['name'] = $name;
                $image['image'][0]['url'] = DIRECTORY_SEPARATOR . UrlInterface::URL_TYPE_MEDIA
                    . DIRECTORY_SEPARATOR . $url;
                $fullData = $this->loadedData;
                $this->loadedData[$slide->getId()] = array_merge($fullData[$slide->getId()], $image);
            }
        }

        return $this->loadedData;
    }
}
