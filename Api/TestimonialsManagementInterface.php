<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Api;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Overdose\Testimonials\Api\Data\TestimonialInterface;

interface TestimonialsManagementInterface
{
    /**
     * Creates testimonial
     *
     * @param array $data
     * @return TestimonialInterface|null
     * @throws InputException
     * @throws LocalizedException
     */
    public function create(array $data): ?TestimonialInterface;
}
