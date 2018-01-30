<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 07.12.17
 * Time: 14:55
 */

namespace Margo\Testimonials\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Validator\EmailAddress;
use Magento\Framework\DataObject;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Area;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class TestimonialsObserver implements ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT = 'testimonials/testimonials_email/email';

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var EmailAddress
     */
    protected $validatorEmail;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TestimonialsFactory
     */
    protected $_testimonials;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * TestimonialsObserver constructor.
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param EmailAddress $validatorEmail
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        EmailAddress $validatorEmail,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->validatorEmail = $validatorEmail;
        $this->_transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *  Handler for 'margo_testimonials' event.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // send email to admin with customer name & his testimonials
        $customer = $observer->getData('customer');
        $testimonial = $observer->getData('testimonial');

        $full_name = $customer['firstname'] . ' ' . $customer['lastname'];
        $description = $testimonial['description'];
        $email = $customer['email'];
        $date = $testimonial['create_time'];

        $storeScope = ScopeInterface::SCOPE_STORE;

        //checking email is valid then send email
        if ($this->validatorEmail->isValid($email)) {
            $customerObject = new DataObject();

            $templateParams = [
                'date' => $date,
                'full_name' => $full_name,
                'email' => $email,
                'description' => $description
            ];
            $customerObject->setData($templateParams);

            $this->_transportBuilder->setTemplateIdentifier(
                'margo_testimonials_email_template'
            )->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ]
            )->setTemplateVars(
                ['data' => $customerObject]
            )->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope));
            $transport = $this->_transportBuilder->getTransport();
            try {
                $transport->sendMessage();
            } catch (\Exception $e) {
                ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
            }
        }
    }
}