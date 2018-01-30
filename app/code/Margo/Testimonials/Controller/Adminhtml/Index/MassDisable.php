<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 15.11.17
 * Time: 11:22
 */

namespace Margo\Testimonials\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Margo\Testimonials\Controller\Adminhtml\Index;

class MassDisable extends Index
{

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setIsActive(false);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}