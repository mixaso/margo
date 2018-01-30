<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.10.17
 * Time: 16:09
 */

namespace Margo\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;

class Testimonials extends AbstractModel
{


    protected function _construct() {
        $this->_init('Margo\Testimonials\Model\Resource\CustomerTestimonials');
    }
}