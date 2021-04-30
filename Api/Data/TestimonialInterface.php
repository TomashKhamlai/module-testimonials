<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Api\Data;

interface TestimonialInterface
{

    /**#@+
     * Constants defined for keys of the data array
     */
    const ENTITY_ID = 'entity_id';
    const AUTHOR = 'author';
    const MESSAGE = 'message';
    const IMAGE = 'image';
    const STORE_ID = 'store_id';
    /**#@-*/

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return TestimonialInterface
     */
    public function setTitle(string $title): TestimonialInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return TestimonialInterface
     */
    public function setMessage(string $message): TestimonialInterface;

    /**
     * @return string
     */
    public function getImageUrl(): string;

    /**
     * @param string $imageUrl
     * @return TestimonialInterface
     */
    public function setImageUrl(string $imageUrl): TestimonialInterface;

    /**
     * @return string
     */
    public function getStoreId(): string;

    /**
     * @param string $storeId
     * @return TestimonialInterface
     */
    public function setStoreId(string $storeId): TestimonialInterface;

}
