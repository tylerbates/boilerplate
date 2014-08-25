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

/**
 * Sales observer
 *
 * @category   Oggetto
 * @package    Oggetto_Sales
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Sales_Model_Observer
{
    /**
     * Adds virtual grid column to order grid records generation
     *
     * @param Varien_Event_Observer $observer Observer
     * @return void
     */
    public function addColumnsToResource(Varien_Event_Observer $observer)
    {
        /* @var $resource Mage_Sales_Model_Mysql4_Order */
        $resource = $observer->getEvent()->getResource();
        $resource->addVirtualGridColumn(
            'customer_telephone',
            'sales/order_address',
            array('billing_address_id' => 'entity_id'),
            'telephone'
        );
    }

    /**
     * Create Invoice after order creation
     *
     * @param Varien_Event_Observer $observer observer
     * @return void
     */
    public function createInvoiceAfterOrderCreation(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $invoiceId = Mage::getModel('sales/order_invoice_api')
            ->create($order->getIncrementId(), array());
    }
}