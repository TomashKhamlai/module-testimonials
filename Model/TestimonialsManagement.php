<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Model;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Overdose\Testimonials\Api\Data\TestimonialInterface;
use Overdose\Testimonials\Api\TestimonialsManagementInterface;

class TestimonialsManagement implements TestimonialsManagementInterface
{

    /**
     * @var TestimonialFactory
     */
    private $testimonialFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TestimonialsRepository
     */
    private $testimonialsRepository;

    public function __construct(
        TestimonialFactory $testimonialFactory,
        TestimonialsRepository $testimonialsRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialsRepository = $testimonialsRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?TestimonialInterface
    {
        $exception = new InputException();
        if (!$data[TestimonialInterface::AUTHOR]) {
            $exception->addError(__('You must specify "%key"', ['key' => TestimonialInterface::AUTHOR]));
        }
        if (!$data[TestimonialInterface::MESSAGE]) {
            $exception->addError(__('You must specify "%key"', ['key' => TestimonialInterface::MESSAGE]));
        }
        if (!$data[TestimonialInterface::IMAGE]) {
            $exception->addError(__('You must specify "%key"', ['key' => TestimonialInterface::IMAGE]));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }

        $newTestimonial = $this->testimonialFactory->create();
        $newTestimonial
            ->setData(TestimonialInterface::MESSAGE, $data[TestimonialInterface::MESSAGE])
            ->setData(TestimonialInterface::AUTHOR, $data[TestimonialInterface::AUTHOR])
            ->setData(TestimonialInterface::IMAGE, $data[TestimonialInterface::IMAGE])
            ->setData(TestimonialInterface::STORE_ID, $this->storeManager->getStore()->getId());

        try {
            $this->testimonialsRepository->save($newTestimonial);
        } catch (AlreadyExistsException $exception) {
            throw new LocalizedException(__('This order already has associated lead entity'), $exception);
        }

        return $newTestimonial;
    }
}
