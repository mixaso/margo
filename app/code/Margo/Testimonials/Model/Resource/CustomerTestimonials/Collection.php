<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.10.17
 * Time: 13:23
 */

namespace Margo\Testimonials\Model\Resource\CustomerTestimonials;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Margo\Testimonials\Model\Testimonials;
use Margo\Testimonials\Model\Resource\CustomerTestimonials;
use Magento\Framework\DB\Select;

class Collection extends AbstractCollection
{

    protected  $_idFieldName = 'id';
    /**
     * Define module
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Testimonials::class,
            CustomerTestimonials::class
        );
    }

    /**
     * Initialize select
     *
     * @return $this
     *
     * Join two table customer_testimonials & customer_entity, & in table customer_testimonials add data two col firstname & lastname with table customer_entity in table customer_testimonials
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ['ce1' => 'customer_entity'],
                'ce1.entity_id = main_table.customer_id',
                [
                    'customer_first_name' => 'firstname',
                    'customer_last_name' => 'lastname',
                ]
            )->joinLeft(
                ['ce2' => 'customer_entity_varchar'],
                'ce2.entity_id=ce1.entity_id',
                ['customer_entity_first_name' => 'value'])
            ->joinLeft(
                ['ce3' => 'customer_entity_varchar'],
                'ce3.entity_id=ce1.entity_id',
                ['customer_entity_last_name' => 'value']
            );
        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return \Magento\Framework\DB\Select
     */
    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Select::ORDER);
        $idsSelect->reset(Select::LIMIT_COUNT);
        $idsSelect->reset(Select::LIMIT_OFFSET);
        $idsSelect->reset(Select::COLUMNS);
        $idsSelect->columns($this->getResource()->getIdFieldName(), 'main_table');
        $idsSelect->limit($limit, $offset);
        return $idsSelect;
    }
}