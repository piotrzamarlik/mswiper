<?php

namespace Piotrek\Slider\Test\Unit\Ui\DataProvider\Slider;

use Piotrek\Slider\Model\ResourceModel\Slide\Collection;
use Piotrek\Slider\Model\ResourceModel\Slide\CollectionFactory;
use Piotrek\Slider\Ui\DataProvider\Slider\DataProvider;
use Magento\Framework\Api\FilterBuilder;
use PHPUnit\Framework\TestCase;
use Piotrek\Slider\Model\Slide;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;
use PHPUnit\Framework\MockObject\MockObject;

class DataProviderTest extends TestCase
{
    /**
     * @var CollectionFactory $collectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var Reporting|MockObject
     */
    private $reportingMock;

    /**
     * @var SearchCriteriaBuilder|MockObject
     */
    private $searchCriteriaBuilderMock;

    /**
     * @var RequestInterface|MockObject
     */
    private $requestInterfaceMock;

    /**
     * @var FilterBuilder|MockObject
     */
    private $filterBuilderMock;

    /**
     * @var DataProvider
     */
    private DataProvider $dataProvider;

    /**
     * @var string
     */
    private string $name = 'slide_form_data_source';

    /**
     * @var string
     */
    private string $primaryFieldName = 'id';

    /**
     * @var string
     */
    private string $requestFieldName = 'id';

    protected function setUp(): void
    {
        $this->reportingMock = $this->createMock(Reporting::class);
        $this->searchCriteriaBuilderMock = $this->createMock(SearchCriteriaBuilder::class);
        $this->requestInterfaceMock = $this->createMock(RequestInterface::class);
        $this->filterBuilderMock = $this->createMock(FilterBuilder::class);
        $this->collectionFactory = $this->createPartialMock(
            CollectionFactory::class,
            ['create']
        );

        $this->dataProvider = new DataProvider(
            $this->name,
            $this->primaryFieldName,
            $this->requestFieldName,
            $this->reportingMock,
            $this->searchCriteriaBuilderMock,
            $this->requestInterfaceMock,
            $this->filterBuilderMock,
            $this->collectionFactory
        );
    }

    /**
     * Run test getData method
     *
     * @return void
     */
    public function testGetData()
    {
        $sliders = [
            $this->getSlideMock(),
            $this->getSlideMock()
        ];

        $sliderCollectionMock = $this->createPartialMock(
            Collection::class,
            ['getItems', 'getIterator']
        );

        $iterator = new \ArrayIterator(new \ArrayIterator($sliders));

        $sliderCollectionMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($iterator);

        $sliderCollectionMock->expects($this->once())
            ->method('getItems')
            ->willReturnSelf();

        $this->collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($sliderCollectionMock);

        $result = $this->dataProvider->getData();
        $this->assertIsArray($result);
    }

    /**
     * Create Slide Mock
     *
     * @return Collection|MockObject
     */
    public function getSlideMock()
    {
        return $this->createMock(Slide::class);
    }
}
