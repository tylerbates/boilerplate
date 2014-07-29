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

        $address = $this->_getQuote($request)->getShippingAddress();

        $claimParams = [
            'from_country' => 'Россия',
            'from_region'  => 'Москва',
            'from_city'    => 'Москва',
            'to_country'   => Mage::app()->getLocale()->getCountryTranslation($address->getCountry()),
            'to_region'    => $address->getRegion(),
            'to_city'      => $address->getCity()
        ];

        $claimUrl = 'http://new.oggy.co/shipping/api/rest.php';

        $claim = $claimUrl . '?' . http_build_query($claimParams);

        $claimResult = json_decode(file_get_contents($claim));

        if ($claimResult->status != 'success') {
            return false;
        }

        $prices = (array) $claimResult->prices;

        foreach ($prices as $label => $price) {
//            $price = Mage::helper('directory')->currencyConvert($price, 'RUB');
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($label);
            $method->setMethodTitle($label);
            $method->setCost($price);
            $method->setPrice($price);
            $result->append($method);
        }

        return $result;
    }

    /**
     * retrieve quote from request
     *
     * @param Mage_Shipping_Model_Rate_Request $request Request
     * @return Mage_Sales_Model_Quote
     */
    private function _getQuote($request)
    {
        return $request->getAllItems()[0]->getQuote();
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