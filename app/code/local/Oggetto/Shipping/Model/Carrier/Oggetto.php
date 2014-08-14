<?php
/**
 * Oggetto common Shipping stuff extension for Magento
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
 * the Oggetto Shipping module to newer versions in the future.
 * If you wish to customize the Oggetto Shipping module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @copyright  Copyright (C) 2014 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Oggetto carrier model
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Shipping_Model_Carrier_Oggetto
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * unique internal shipping method identifier
     *
     * @var string [a-z0-9_]
     */
    protected $_code = 'oggetto';

    /**
     * Collect and get rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request Request
     * @return Mage_Shipping_Model_Rate_Result|bool|null
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $result = Mage::getModel('shipping/rate_result');
        $prices = Mage::getModel('oggetto_shipping/calculator')->getPricesForRequest($request);

        if (!$prices) {
            return false;
        }

        foreach ($prices as $label => $price) {
            $price = Mage::helper('oggetto_shipping')->getPriceForBaseCurrency($price);
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle(Mage::helper('oggetto_shipping')->__($this->getConfigData('title')));
            $method->setMethod($label);
            $method->setMethodTitle(Mage::helper('oggetto_shipping')->__($label));
            $method->setCost($price);
            $method->setPrice($price);
            $result->append($method);
        }

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

}