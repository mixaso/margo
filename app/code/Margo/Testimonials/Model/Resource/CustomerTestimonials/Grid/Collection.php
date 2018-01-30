<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 02.11.17
 * Time: 18:33
 */

namespace Margo\Testimonials\Model\Resource\CustomerTestimonials\Grid;

use Margo\Testimonials\Model\Resource\CustomerTestimonials\Collection as TestimonialsCollection;
use Magento\Framework\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Margo\Testimonials\Model\Resource\CustomerTestimonials;
use Magento\Framework\Api\SearchCriteriaInterface;

class Collection extends TestimonialsCollection implements SearchResultInterface
{
    protected $aggregations;

    protected function _construct()
    {
        $this->_init(
            Document::class,
            CustomerTestimonials::class);
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchOne($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }
}