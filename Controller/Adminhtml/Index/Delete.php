<?php

namespace Piotrek\Slider\Controller\Adminhtml\Index;

use Exception;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Piotrek\Slider\Model\ResourceModel\Slide as SlideResource;
use Piotrek\Slider\Model\SlideFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use RuntimeException;

class Delete implements HttpPostActionInterface
{
    /**
     * @var SlideFactory $slideModelFactory
     */
    protected SlideFactory $slideModelFactory;

    /**
     * @var SlideResource $slideResource
     */
    protected SlideResource $slideResource;

    /**
     * @var RequestInterface $request
     */
    protected RequestInterface $request;

    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;

    /**
     * @var RedirectFactory $resultRedirect
     */
    protected RedirectFactory $resultRedirect;

    /**
     * @param SlideFactory $slideModelFactory
     * @param RequestInterface $request
     * @param RedirectFactory $resultRedirectFactory
     * @param ManagerInterface $messageManager
     * @param SlideResource $slideResource
     */
    public function __construct(
        SlideFactory $slideModelFactory,
        RequestInterface $request,
        RedirectFactory $resultRedirectFactory,
        ManagerInterface $messageManager,
        SlideResource $slideResource
    ) {
        $this->request = $request;
        $this->resultRedirect = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        $this->slideModelFactory = $slideModelFactory;
        $this->slideResource = $slideResource;
    }

    /**
     * Save blog record action
     *
     * @return Redirect
     * @throws Exception
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirect->create();
        $slideId = $this->request->getParam('id');
        $slideModel = $this->slideModelFactory->create();
        if ($slideId) {
            try {
                $this->slideResource->load($slideModel, $slideId);
                $this->slideResource->delete($slideModel);
                $this->messageManager->addSuccessMessage(__('The data has been successfully deleted.'));
            } catch (LocalizedException | RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the data.'));
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
