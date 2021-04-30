<?php

declare(strict_types=1);

namespace Overdose\Testimonials\Model\ResourceModel\Testimonial;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Overdose\Testimonials\Model\ResourceModel\Testimonial as ResourceModel;
use Overdose\Testimonials\Model\Testimonial;

class Collection extends AbstractCollection
{

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            Testimonial::class,
            ResourceModel::class
        );
    }

}
