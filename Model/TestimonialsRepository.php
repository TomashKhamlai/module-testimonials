<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Overdose\Testimonials\Api\Data\TestimonialInterface;
use Overdose\Testimonials\Api\Data\TestimonialInterfaceFactory;
use Overdose\Testimonials\Api\Data\TestimonialSearchResultsInterface;
use Overdose\Testimonials\Api\TestimonialsRepositoryInterface;
use Overdose\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Overdose\Testimonials\Api\Data\TestimonialSearchResultsInterfaceFactory;
use Overdose\Testimonials\Model\ResourceModel\Testimonial as TestimonialResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class TestimonialsRepository implements TestimonialsRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var TestimonialSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var TestimonialResourceModel
     */
    private $resourceModel;

    /**
     * @var TestimonialInterfaceFactory
     */
    private $testimonialFactory;

    /**
     * TestimonialsRepository constructor.
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CollectionFactory $collectionFactory
     * @param TestimonialSearchResultsInterfaceFactory $searchResultsFactory
     * @param TestimonialInterfaceFactory $testimonialFactory
     * @param TestimonialResourceModel $resourceModel
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        TestimonialSearchResultsInterfaceFactory $searchResultsFactory,
        TestimonialResourceModel $resourceModel
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TestimonialSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(TestimonialInterface $testimonial): TestimonialInterface
    {
        /** @var Testimonial $testimonial */
        $this->resourceModel->save($testimonial);
        return $testimonial;
    }
}
