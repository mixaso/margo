<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 30.10.17
 * Time: 9:13
 */

namespace Margo\Testimonials\Block;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;


class Header extends Template {
    public function __construct(
        Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
    }
}