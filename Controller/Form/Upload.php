<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Controller\Form;

use Exception;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\UrlInterface;

class Upload implements HttpPostActionInterface
{
    const TESTIMONIALS_FOLDER = 'testimonials';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var JsonFactory
     */
    private $resultFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Upload constructor.
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     * @param JsonFactory $resultFactory
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        JsonFactory $resultFactory,
        UrlInterface $urlBuilder
    ) {
        $this->request = $context->getRequest();
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->urlBuilder = $urlBuilder;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $context->getMessageManager();
    }

    public function execute()
    {
        $data = [];
        $requestData = $this->request->getParams();
        $resultJsonObject = $this->resultFactory->create();
        if ($requestData) {
            $files = $this->request->getFiles();
            if (isset($files['image']) && !empty($files['image']["name"])) {
                try {
                    $imageAdapter = $this->adapterFactory->create();
                    $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                    $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'webp'])
                        ->setAllowRenameFiles(true)
                        ->setFilesDispersion(true)
                        ->addValidateCallback(
                            'testimonial_image_upload',
                            $imageAdapter,
                            'validateUploadFile'
                        );

                    $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                    $destinationPath = $mediaDirectory->getAbsolutePath(self::TESTIMONIALS_FOLDER);
                    $result = $uploaderFactory->save($destinationPath);

                    $result['file'] = self::TESTIMONIALS_FOLDER . $result['file'];
                    $result['url'] = $this->urlBuilder->getDirectUrl($result['file'], ['_type' => UrlInterface::URL_TYPE_MEDIA]);
                    unset($result['tmp_name'], $result['path']);

                    if (!$result) {
                        throw new LocalizedException(
                            __('File cannot be saved to path: $1', $destinationPath)
                        );
                    }

                    $imagePath = 'testimonials' . $result['file'];
                    //Set file path with name for save into database
                    $data['image'] = $imagePath;
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        }

        return $resultJsonObject->setData($result);
    }
}
