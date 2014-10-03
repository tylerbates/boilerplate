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
    $idxTable = $installer->getConnection()
        ->newTable($installer->getTable('news/article_category_idx'))
        ->addColumn(
            'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ), 'Index ID'
        )
        ->addColumn(
            'category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Category ID'
        )
        ->addColumn(
            'article_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Article ID'
        )
        ->setComment('News article category index table');

    $installer->getConnection()->createTable($idxTable);
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();