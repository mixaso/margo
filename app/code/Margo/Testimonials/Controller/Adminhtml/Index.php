<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Margo\Testimonials\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Margo\Testimonials\Model\Resource\CustomerTestimonials\CollectionFactory;
use Magento\Backend\App\Action;

/**
 * Newsletter subscribers controller
 */
abstract class Index extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ){
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
}
