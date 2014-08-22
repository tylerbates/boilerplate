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
 * the Oggetto Payment module to newer versions in the future.
 * If you wish to customize the Oggetto Payment module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Payment request processor
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Payment_Model_Request extends Mage_Core_Model_Abstract
{
    /** @var  Mage_Sales_Model_Order  */
    private $_order = null;

    /**
     * Get order to generete fields
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (!$this->_order) {
            $this->_order = Mage::getSingleton('checkout/session')->getLastRealOrder();
        }

        return $this->_order;
    }

    /**
     * get request form fields
     *
     * @return array
     */
    public function getFormFields()
    {
        $fields = [
            'order_id'           => $this->getOrder()->getIncrementId(),
            'total'              => $this->_getPriceFormatted(),
            'items'              => $this->_getOrderItems(),
            'success_url'        => Mage::getUrl('oggypay/redirect/success'),
            'error_url'          => Mage::getUrl('oggypay/redirect/fail'),
            'payment_report_url' => Mage::getUrl('oggypay/callback/index'),
        ];

        $fields['hash'] = $this->_generateHash($fields);
        return $fields;
    }

    /**
     * get price in rubles
     *
     * @return float
     */
    private function _getPriceFormatted()
    {
        $price = Mage::helper('directory')->currencyConvert(
            $this->getOrder()->getGrandTotal(),
            Mage::app()->getStore()->getCurrentCurrencyCode(),
            'RUB'
        );

        return number_format((float) $price, 2, '.', '');
    }

    /**
     * Get formatted order Items
     *
     * @return string
     */
    private function _getOrderItems()
    {
        $items = [];
        /** @var Mage_Sales_Model_Order_Item $_item */
        foreach ($this->getOrder()->getAllVisibleItems() as $_item) {
            $itemInfo = $_item->getName() . ' : ' .
                (int) $_item->getQtyOrdered() .
                Mage::helper('oggetto_payment')->__('pcs');
            $items[] = $itemInfo;
        }
        return implode(',', $items);
    }

    /**
     * get request Hash
     *
     * @param array $fields Form fields
     * @return string
     */
    private function _generateHash($fields)
    {
        ksort($fields, SORT_STRING);
        $queryString = '';
        foreach ($fields as $key => $value) {
            $queryString .= $key . ':' . $value . '|';
        }
        $queryString .= Mage::helper('oggetto_payment')->getSecretKey();
        return md5($queryString);
    }
}