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
 * Sales adminhtml helper
 *
 * @category   Oggetto
 * @package    Oggetto_Sales
 * @subpackage Helper
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Sales_Helper_Adminhtml extends Mage_Core_Helper_Abstract
{
    /**
     * get telephone column definition
     *
     * @return array
     */
    public function getTelephoneColumnDefinition()
    {
        return [
            'header' => Mage::helper('oggetto_sales/adminhtml')->__('Telephone'),
            'index' => 'customer_telephone',
            'type' => 'text'
        ];
    }

    /**
     * get shipping method column definition
     *
     * @return array
     */
    public function getShippingMethodColumnDefinition()
    {
        return [
            'header' => Mage::helper('oggetto_sales/adminhtml')->__('Shipping Method'),
            'index' => 'shipping_description',
            'type' => 'text'
        ];
    }
}