<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 05.10.17
 * Time: 19:17
 */

namespace Margo\Logo\Block\Html\Header;


class Logo extends \Magento\Theme\Block\Html\Header\Logo
{
    protected $_template = 'html/header/logo.phtml';

    /**
     * Retrieve logo class
     *
     * @return string
     */
    public function getLogoClass()
    {
        if (empty($this->_data['logo_class'])) {
            $this->_data['logo_class'] = $this->_scopeConfig->getValue(
                'design/header/logo_class',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return $this->_data['logo_class'];
    }
}