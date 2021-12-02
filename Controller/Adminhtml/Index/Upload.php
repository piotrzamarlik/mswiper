<?php

namespace Piotrek\Slider\Controller\Adminhtml\Index;

use Exception;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Piotrek\Slider\Model\ImageUploader;

/**
 * Class Upload
 */
class Upload implements HttpPostActionInterface
{
    /**
    * @var ResultFactory $resultFactory
    */
    protected ResultFactory $resultFactory;

    /**
     * @var RequestInterface $resultFactory
     */
    protected RequestInterface $request;

    /**
     * @var ImageUploader $resultFactory
     */
    protected ImageUploader $imageUploader;

    /**
     * Upload constructor.
     *
     * @param RequestInterface $request
     * @param ImageUploader $imageUploader
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        RequestInterface $request,
        ImageUploader $imageUploader,
        ResultFactory $resultFactory
    ) {
        $this->request = $request;
        $this->imageUploader = $imageUploader;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $imageId = $this->request->getParam('param_name');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $jsonResult->setData($result);
    }
}
