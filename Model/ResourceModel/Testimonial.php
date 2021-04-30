<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Testimonial extends AbstractDb
{

    /**
     * Constants
     */
    const TESTIMONIALS_TABLE = 'testimonials';

    /**
     * Testimonial constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TESTIMONIALS_TABLE, 'entity_id');
    }

}
