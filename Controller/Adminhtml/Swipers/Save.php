<?php

namespace Piotrek\Slider\Controller\Adminhtml\Swipers;

use Piotrek\Slider\Model\SwiperFactory;
use Piotrek\Slider\Model\ResourceModel\Swiper as SwiperResource;
use Exception;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use RuntimeException;

class Save implements HttpPostActionInterface
{
    /**
     * @var SwiperFactory $swiperModelFactory
     */
    protected SwiperFactory $swiperModelFactory;

    /**
     * @var SwiperResource $swiperResource
     */
    protected SwiperResource $swiperResource;

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
     * @param SwiperFactory $swiperModelFactory
     * @param RequestInterface $request
     * @param RedirectFactory $resultRedirectFactory
     * @param ManagerInterface $messageManager
     * @param SwiperResource $swiperResource
     */
    public function __construct(
        SwiperFactory $swiperModelFactory,
        RequestInterface $request,
        RedirectFactory $resultRedirectFactory,
        ManagerInterface $messageManager,
        SwiperResource $swiperResource
    ) {
        $this->request = $request;
        $this->resultRedirect = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        $this->swiperModelFactory = $swiperModelFactory;
        $this->swiperResource = $swiperResource;
    }

    /**
     * Save blog record action
     *
     * @return Redirect
     * @throws Exception
     */
    public function execute(): Redirect
    {
        $data = $this->request->getParams();
        $swiperId = $this->request->getParam('id');
        $resultRedirect = $this->resultRedirect->create();
        $swiperModel = $this->swiperModelFactory->create();

        if ($data) {
            if ($swiperId) {
                $this->swiperResource->load($swiperModel, $swiperId);
            }
            $swiperModel->addData($data);
            try {
                $this->swiperResource->save($swiperModel);
                $this->messageManager->addSuccessMessage(__('The data has been saved.'));
                return $resultRedirect->setPath('*/swipers/');
            } catch (LocalizedException | RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }
            return $resultRedirect->setPath('*/swipers/index');
        }
        return $resultRedirect->setPath('*/*/');
    }
}
