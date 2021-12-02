<?php

namespace Piotrek\Slider\Ui\Component\Columns;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Preview extends Column
{
    public const NAME_FOR_PATH = 'image_path';
    /**
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManagerInterface;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManagerInterface,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManagerInterface = $storeManagerInterface;
    }

    public function prepareDataSource(array $dataSource): array
    {
        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($item['image_path'])) {
                $url = $this->storeManagerInterface
                        ->getStore()
                        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $item['image_path'];
                $item[self::NAME_FOR_PATH . '_src'] = $url;
                $item[self::NAME_FOR_PATH . '_alt'] = $item['name'];
                $item[self::NAME_FOR_PATH . '_link'] = $url;
                $item[self::NAME_FOR_PATH . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}
