<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.10.17
 * Time: 16:25
 */

namespace Margo\Testimonials\Controller\Index;

use \Magento\Framework\App\Action\Context;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\View\Page\Config;
use \Magento\Store\Model\ScopeInterface;

class Index extends Action {

    protected $_resultPageFactory;

    protected $_scopeConfig;

    protected $_pageConfig;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig,
        Config $pageConfig
    ){
        $this->_resultPageFactory = $resultPageFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_pageConfig = $pageConfig;
        parent::__construct($context);
    }

    public function execute(){
        $resultPage = $this->_resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(
            $this->_scopeConfig->getValue('testimonials/seo/title', ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setKeywords(
            $this->_scopeConfig->getValue('testimonials/seo/keywords', ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->setDescription(
            $this->_scopeConfig->getValue('testimonials/seo/description', ScopeInterface::SCOPE_STORE)
        );

        return $resultPage;
    }
}