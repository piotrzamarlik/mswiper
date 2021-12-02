<?php

namespace Piotrek\Slider\Controller\Adminhtml\Swipers;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Renders Sliders Index
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Piotrek_Slider::sliders');
        $resultPage->getConfig()->getTitle()->prepend((__('Swipers')));

        return $resultPage;
    }
}
