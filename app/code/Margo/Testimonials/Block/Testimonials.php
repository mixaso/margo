<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.10.17
 * Time: 16:31
 */

namespace Margo\Testimonials\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Margo\Testimonials\Model\TestimonialsFactory;

class Testimonials extends Template
{
    /**
     * @var TestimonialsFactory
     */
    protected $_testimonials;

    public function __construct(
        TestimonialsFactory $testimonialsFactory,
        Context $context,
        array $data = []
    )
    {
        $this->_testimonials = $testimonialsFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return
     */
    public function getTestimonials()
    {
        //get values of current page. if not the param value then it will set to 1
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        //get values of current limit. if not the param value then it will set to 1
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        $model = $this->_testimonials->create()->getCollection();
        $model->setPageSize($pageSize);
        $model->setCurPage($page);
        $model->setOrder('id', 'DESC');
        $model->addFieldToFilter('main_table.is_active', 1);
        return $model;
    }

    protected function _prepareLayout()
    {
        if ($this->getTestimonials()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'margo.testimonials.pager'
            )->setTemplate('Margo_Testimonials::html/pager.phtml')
                ->setAvailableLimit(array(5 => 5, 10 => 10, 15 => 15))
                ->setShowPerPage(true)
                ->setCollection(
                    $this->getTestimonials()
                );
            $this->setChild('pager', $pager);
            $this->getTestimonials()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}