<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Margo\Demo\Setup;

use Magento\Framework\Setup;
use Margo\Demo\Model\Page as DemoPage;
use Margo\Demo\Model\Block as DemoBlock;
use Magento\CmsSampleData\Model\Page;
use Magento\CmsSampleData\Model\Block;

class Installer implements Setup\SampleData\InstallerInterface {

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Block
     */
    private $block;

    /**
     * @param DemoPage $demoPage
     * @param DemoBlock $demoBlock
     */
    public function __construct(
        DemoPage $demoPage,
        DemoBlock $demoBlock
    ) {
        $this->page = $demoPage;
        $this->block = $demoBlock;
    }

    /**
     * {@inheritdoc}
     */
    public function install() {

        $this->page->install(
                [
                    'Margo_Demo::DemoPages/pages.csv',
                ]
        );
        $this->block->install(
                [
                    'Margo_Demo::DemoBlocks/blocks.csv',
                ]
        );
    }

}
