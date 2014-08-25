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
 * Payment model
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Payment_Model_Method_Payment extends Mage_Payment_Model_Method_Abstract
{
    /**
     * Method code
     *
     * @var string
     */
    protected $_code = 'oggetto';

    /**
     * Parameter to get invoice not in "paid" status
     *
     * @var boolean
     */
    protected $_canCapture = true;

    /**
     * Parameter to allow to partially invoice order
     *
     * @var boolean
     */
    protected $_canCapturePartial = true;

    /**
     * returns redirect url
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('oggypay/redirect', array('_secure' => true));
    }
}