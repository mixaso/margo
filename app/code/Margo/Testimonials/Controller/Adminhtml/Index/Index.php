<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 01.11.17
 * Time: 14:31
 */

namespace Margo\Testimonials\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ){
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}