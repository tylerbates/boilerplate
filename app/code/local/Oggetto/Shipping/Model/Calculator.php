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
 * Oggetto shipping calculator
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Shipping_Model_Calculator
{
    const ORIGIN_COUNTRY = 'shipping/origin/country_id';

    const ORIGIN_REGION = 'shipping/origin/region_id';

    const ORIGIN_CITY = 'shipping/origin/city';

    const CLAIM_URL = 'carriers/oggetto/claim_url';

    /**
     * Retrieve prices info through api
     *
     * @param Mage_Shipping_Model_Rate_Request $request Request
     * @return array|bool
     */
    public function getPricesForRequest($request)
    {
        $address = $this->_getQuote($request)->getShippingAddress();
        $claimParams = $this->_getClaimParams($address);
        $claimUrl = Mage::getStoreConfig(self::CLAIM_URL);
        $claim = $claimUrl . '?' . http_build_query($claimParams);
        $claimResult = json_decode(file_get_contents($claim));
        if ($claimResult->status != 'success') {
            return false;
        }
        return (array) $claimResult->prices;
    }

    /**
     * Retrieve claim params
     *
     * @param Mage_Sales_Model_Quote_Address $address Address
     * @return array
     */
    private function _getClaimParams($address)
    {
        return [
            'from_country' => Mage::app()->getLocale()
                ->getCountryTranslation(Mage::getStoreConfig(self::ORIGIN_COUNTRY)),
            'from_region'  => Mage::getModel('directory/region')
                ->load(Mage::getStoreConfig(self::ORIGIN_REGION))->getName(),
            'from_city'    => Mage::getStoreConfig(self::ORIGIN_CITY),
            'to_country'   => Mage::app()->getLocale()->getCountryTranslation($address->getCountry()),
            'to_region'    => $address->getRegion(),
            'to_city'      => $address->getCity()
        ];
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
}