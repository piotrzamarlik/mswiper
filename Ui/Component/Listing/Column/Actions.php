<?php

namespace Piotrek\Slider\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_EDIT = 'slider/index/edit';
    const URL_PATH_DELETE = 'slider/index/delete';

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->context->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->context->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'post' => true,
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1 ?', $item['name']),
                                'message' => __('Are you sure you wan\'t to delete %1 ?', $item['name'])
                            ]
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
