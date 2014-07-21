<?php
/**
 * Oggetto common Sales stuff extension for Magento
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
 * the Oggetto Sales module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Sales
 * @copyright  Copyright (C) 2014 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/** @var Mage_Sales_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

try {
    $this->getConnection()->addColumn(
        $this->getTable('sales/order_grid'),
        'customer_telephone',
        "varchar(255) not null default ''"
    );

    $this->getConnection()->addKey(
        $this->getTable('sales/order_grid'),
        'customer_telephone',
        'customer_telephone'
    );

    $select = $this->getConnection()->select();
    $select->join(
        array('address' => $this->getTable('sales/order_address')),
        $this->getConnection()->quoteInto(
            'address.parent_id = order_grid.entity_id AND address.address_type = ?',
            Mage_Sales_Model_Quote_Address::TYPE_BILLING
        ),
        array('customer_telephone' => 'telephone')
    );
    $this->getConnection()->query(
        $select->crossUpdateFromSelect(
            array('order_grid' => $this->getTable('sales/order_grid'))
        )
    );

    $this->getConnection()->addColumn(
        $this->getTable('sales/order_grid'),
        'shipping_description',
        "varchar(255) not null default ''"
    );

    $this->getConnection()->addKey(
        $this->getTable('sales/order_grid'),
        'shipping_description',
        'shipping_description'
    );

    $select = $this->getConnection()->select();
    $select->join(
        array('order' => $this->getTable('sales/order')),
        $this->getConnection()->quoteInto(
            'order.entity_id = order_grid.entity_id'
        ),
        array('shipping_description' => 'shipping_description')
    );
    $this->getConnection()->query(
        $select->crossUpdateFromSelect(
            array('order_grid' => $this->getTable('sales/order_grid'))
        )
    );
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();
