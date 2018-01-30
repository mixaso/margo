<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 26.10.17
 * Time: 12:21
 */
namespace Margo\Testimonials\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable('customer_testimonials');
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null, [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true,
                            'auto_increment' => true
                        ], 'ID')
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null, [
                            'unsigned' => true,
                            'nullable' => false
                        ], 'Customer ID')
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null, [
                            'nullable' => true,
                            'fulltext' => true,
                            'default' => null
                        ], 'Description')
                ->addColumn(
                    'create_time',
                    Table::TYPE_TIMESTAMP,
                    null, [
                            'nullable' => true,
                            'default' => Table::TIMESTAMP_INIT
                        ], 'Create Time')
                ->addColumn(
                    'update_time',
                    Table::TYPE_TIMESTAMP,
                    null, [
                            'nullable' => true,
                            'default' => Table::TIMESTAMP_INIT
                        ], 'Update Time')
                ->setComment('Testimonials Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
?>