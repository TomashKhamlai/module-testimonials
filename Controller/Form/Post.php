<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Controller\Form;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Overdose\Testimonials\Model\TestimonialsManagement;

class Post implements HttpPostActionInterface
{

    /**
     * @var JsonFactory
     */
    private $resultFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var TestimonialsManagement
     */
    private $testimonialsManagement;

    /**
     * @param JsonFactory $resultFactory
     * @param Context $context
     */
    public function __construct(
        TestimonialsManagement $testimonialsManagement,
        JsonFactory $resultFactory,
        Context $context
    ) {
        $this->testimonialsManagement = $testimonialsManagement;
        $this->resultFactory = $resultFactory;
        $this->request = $context->getRequest();
    }

    public function execute()
    {
        $resultJsonObject = $this->resultFactory->create();
        $data = $this->request->getParams();

        if ($data) {
            $dataObject = [
                    'author' => $data['author'],
                    'message' => $data['message'],
                    'image' => $data['image'][0]['file'],
                ];

            try {
                $this->testimonialsManagement->create($dataObject);
            } catch (InputException $e) {
                return $resultJsonObject->setData($e->getErrors());
            } catch (LocalizedException $e) {
                return $resultJsonObject->setData(['status' => 'empty']);
            }

            return $resultJsonObject->setData(['status' => 'created']);
        }

        return false;
    }
}
