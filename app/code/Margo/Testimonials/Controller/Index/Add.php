<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.10.17
 * Time: 15:48
 */

namespace Margo\Testimonials\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Margo\Testimonials\Model\TestimonialsFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Manager;

class Add extends Action
{

    /**
     * Core form key validator
     *
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;
    protected $customerSession;
    protected $testimonialsFactory;
    protected $resultJsonFactory;
    protected $eventManager;

    public function __construct(
        Context $context,
        Session $customerSession,
        TestimonialsFactory $testimonialsFactory,
        Validator $formKeyValidator,
        JsonFactory    $resultJsonFactory,
        Manager $eventManager
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->testimonialsFactory = $testimonialsFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->eventManager = $eventManager;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        $result = $this->resultJsonFactory->create();

        if (!$this->customerSession->getCustomer()->getId() or !$this->formKeyValidator->validate($this->getRequest()
            )) {
            return $resultRedirect;
        }

        if ($this->getRequest()->isXmlHttpRequest())
        {
            $response = [
                'errors' => false,
                'message' => __('Your testimonial will be published after moderation')
            ];
            try {
                $testimonial = $this->testimonialsFactory->create();
                $testimonial->setCustomerId($this->customerSession->getCustomer()->getId());
                $testimonial->setDescription($this->getRequest()->getParam('description'));
                $testimonial->setCreateTime(date('Y-m-d h:i:s', time()));
                $testimonial->save();

                $this->eventManager->dispatch('customer_testimonials_success', [
                    'customer' => (array)$this->customerSession->getCustomer()->getData(),
                    'testimonial' => (array)$testimonial->getData()
                ]);
            }  catch (\Exception $e) {
                $response = [
                    'errors' => true,
                    'message' => __('Server Error.')
                ];
            }

            return $result->setData($response);
        }
    }
}