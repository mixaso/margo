<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.10.17
 * Time: 16:56
 */

namespace Margo\Testimonials\Block;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Data\Form\FormKey;

class Form extends Template {
    protected $_formKey;

    public function __construct(
        FormKey $formKey,
        Context $context,
        array $data = []
    ){
        $this->_formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve Session Form Key
     *
     * @return string
     */
    public function getFormKey()
    {
        return $this->_formKey->getFormKey();
    }
}
?>