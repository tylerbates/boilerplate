<?php
/**
 * Oggetto extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto News module to newer versions in the future.
 * If you wish to customize the Oggetto News module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

try {
    $articleTable = $installer->getConnection()
        ->newTable($installer->getTable('news/article'))
        ->addColumn(
            'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Article ID'
        )
        ->addColumn(
            'category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Category ID'
        )
        ->addColumn(
            'label', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Article label'
        )
        ->addColumn(
            'active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(), 'Is article active'
        )
        ->addColumn(
            'url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Article URL key'
        )
        ->addColumn(
            'created_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(), 'Creation date'
        )
        ->addColumn(
            'text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Article text'
        )
        ->setComment('News articles entities');

    $categoryTable = $installer->getConnection()
        ->newTable($installer->getTable('news/category'))
        ->addColumn(
            'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Category ID'
        )
        ->addColumn(
            'parent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Parent category ID'
        )
        ->addColumn(
            'label', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Category label'
        )
        ->addColumn(
            'url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Category URL key'
        )
        ->addColumn(
            'sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'sort order'
        )
        ->setComment('News articles entities');
    $installer->getConnection()->createTable($articleTable);
    $installer->getConnection()->createTable($categoryTable);
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();