<?php

namespace Piotrek\Slider\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Piotrek_Slider::slider';

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Renders sliders edit form
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Piotrek_Slider::sliders');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit'));

        return $resultPage;
    }
}
