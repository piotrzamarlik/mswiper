<?php

namespace Piotrek\Slider\Controller\Adminhtml\Index;

use Piotrek\Slider\Model\ImageUploader;
use Piotrek\Slider\Model\SlideFactory;
use Piotrek\Slider\Model\ResourceModel\Slide as SlideResource;
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
    protected const BASE_URL = 'slider\images';
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

    protected ImageUploader $imageUploader;

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
        ImageUploader $imageUploader,
        SlideResource $slideResource
    ) {
        $this->request = $request;
        $this->resultRedirect = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        $this->slideModelFactory = $slideModelFactory;
        $this->imageUploader = $imageUploader;
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
        $data = $this->request->getParams();
        $slideId = $this->request->getParam('id');
        $resultRedirect = $this->resultRedirect->create();
        $slideModel = $this->slideModelFactory->create();

        if ($data) {
            $image = $data['image'][0];
            try {
                if (isset($data['image'][0]['tmp_name'])) {
                    $result = $this->imageUploader->moveFileFromTmp($image['name']);
                    $imageUrl = self::BASE_URL . '\\' . $result;
                    $data['image_path'] = $imageUrl;
                }
                $data['swiper_id'] = $data['swiper_id'] == '' ? null : $data['swiper_id'];
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
            unset($data['image']);

            if ($slideId) {
                $this->slideResource->load($slideModel, $slideId);
            }
            $slideModel->addData($data);
            try {
                $this->slideResource->save($slideModel);
                $this->messageManager->addSuccessMessage(__('The data has been saved.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException | RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }
            return $resultRedirect->setPath('*/*/index');
        }
        return $resultRedirect->setPath('*/*/');
    }
}
