<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.11.17
 * Time: 11:23
 */

namespace Margo\Testimonials\Controller\Adminhtml\Index;

use Margo\Testimonials\Controller\Adminhtml\Index;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDelete
 */
class MassDelete extends Index
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
        $itemDeleted = 0;
        foreach ($collection as $item) {
            $item->delete();
            $itemDeleted++;
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $itemDeleted));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}