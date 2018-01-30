<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 15.11.17
 * Time: 11:23
 */

namespace Margo\Testimonials\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Margo\Testimonials\Controller\Adminhtml\Index;

/**
 * Class MassEnable
 */
class MassEnable extends Index
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
            $item->setIsActive(true);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been enabled.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}