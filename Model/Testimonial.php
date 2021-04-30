<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Overdose\Testimonials\Api\Data\TestimonialInterface;

class Testimonial extends AbstractModel implements TestimonialInterface
{

    const CACHE_TAG = 'overdose_t';

    /**
     * @var string
     */
    protected $cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'testimonials_post';

    /**
     * TestimonialEntity constructor.
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\Testimonial::class);
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setTitle(string $title): TestimonialInterface
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage(string $message): TestimonialInterface
    {
        $this->setData(self::MESSAGE, $message);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImageUrl(): string
    {
        return $this->getData(self::IMAGE_URL);
    }

    /**
     * @inheritdoc
     */
    public function setImageUrl(string $imageUrl): TestimonialInterface
    {
        $this->setData(self::IMAGE_URL, $imageUrl);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStoreId(): string
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId(string $storeId): TestimonialInterface
    {
        $this->setData(self::STORE_ID, $storeId);
        return $this;
    }
}
