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
 * Payment redirect block
 *
 * @method Mage_Sales_Model_Order getOrder() Get Order
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage block
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Payment_Block_Redirect extends Mage_Core_Block_Template
{
    /**
     * Get payment claim url
     *
     * @return string
     */
    public function getFormUrl()
    {
        return Mage::helper('oggetto_payment')->getClaimUrl();
    }

    /**
     * Get form fields
     *
     * @return array
     */
    public function getFormFields()
    {
        return Mage::getModel('oggetto_payment/request')->getFormFields();
    }




}
