<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Overdose\Testimonials\Api\Data\TestimonialInterface;
use Overdose\Testimonials\Api\Data\TestimonialSearchResultsInterface;

interface TestimonialsRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TestimonialSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TestimonialSearchResultsInterface;

    /**
     * @param TestimonialInterface $testimonial
     * @return TestimonialInterface
     */
    public function save(TestimonialInterface $testimonial): TestimonialInterface;

}
