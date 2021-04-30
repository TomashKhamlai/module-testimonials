<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\DataObject;

interface TestimonialSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Gets collection of Testimonial entities
     *
     * @return TestimonialInterface[]
     */
    public function getItems(): array;

    /**
     * Sets collection of Testimonial entities
     *
     * @param DataObject[] $items
     * @return TestimonialInterface[]
     */
    public function setItems(array $items): array;
}
