<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 15.11.17
 * Time: 10:52
 */

namespace Margo\Testimonials\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Cms\Model\Block;

class IsActive implements OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Block
     */
    protected $cmsBlock;

    /**
     * Constructor
     *
     * @param \Magento\Cms\Model\Block $cmsBlock
     */
    public function __construct(Block $cmsBlock)
    {
        $this->cmsBlock = $cmsBlock;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsBlock->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}