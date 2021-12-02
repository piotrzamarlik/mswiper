<?php

namespace Piotrek\Slider\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class NewAction implements HttpGetActionInterface
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
     * New slide
     *
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Piotrek_Slider::sliders');
        $resultPage->getConfig()->getTitle()->prepend(__('New'));

        return $resultPage;
    }
}
