<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.10.17
 * Time: 16:14
 */

namespace Margo\Testimonials\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerTestimonials extends AbstractDb {

    protected function _construct() {
        $this->_init('customer_testimonials', 'id');
    }
}