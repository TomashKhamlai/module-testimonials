<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Controller\Form;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

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
     * @param JsonFactory $resultFactory
     * @param Context $context
     */
    public function __construct(
        JsonFactory $resultFactory,
        Context $context
    ) {
        $this->resultFactory = $resultFactory;
        $this->request = $context->getRequest();
    }

    public function execute()
    {
        $resultJsonObject = $this->resultFactory->create();

        $data = $this->request->getParams();
        if ($data) {
            $recordData = [
                'author' => $data['author']
            ];

            $resultJsonObject->setData([
                'data' => $recordData
            ]);

            return $resultJsonObject;
        }

        return false;
    }
}
