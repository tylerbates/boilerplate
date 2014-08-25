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
 * Callback request processor
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Payment_Model_Processor extends Mage_Core_Model_Abstract
{
    /**
     * Payment successfully processed
     */
    const SUCCESS = 200;

    /**
     * Request processing failed due to its invalidity
     */
    const INVALID_REQUEST = 400;

    /**
     * System error occured during request processing
     */
    const SYSTEM_ERROR = 500;

    /**
     * Status, awaited from gateway
     */
    const PAYMENT_PROCEEDED = 1;

    /**
     * @var Mage_Core_Controller_Request_Http
     */
    private $_request = null;

    /**
     * init process from request
     *
     * @param Mage_Core_Controller_Request_Http $request HTTP request
     * @return Oggetto_Payment_Model_Processor
     */
    public function initFromHttp($request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * process callback request
     *
     * @return array
     */
    public function process()
    {
        $result = ['code' => self::SUCCESS, 'text' => ''];
        try {
            $order = Mage::getModel('sales/order')
                ->loadByIncrementId($this->_request->getParam('order_id'));
            $requestFields = $this->_request->getParams();
            unset($requestFields['hash']);
            $hash = Mage::helper('oggetto_payment')->generateHash($requestFields);
            if (!$order->getId()) {
                $result['code'] = self::INVALID_REQUEST;
                $result['text'] = 'Order does not exists';
            }
            if ($hash != $this->_request->getParam('hash')) {
                $result['code'] = self::INVALID_REQUEST;
                $result['text'] = 'Invalid hash';
            }
            if (
                $order->getId() &&
                ($this->_request->getParam('total') != Mage::helper('oggetto_payment')->getPriceFormatted($order))
            ) {
                $result['code'] = self::INVALID_REQUEST;
                $result['text'] = 'Total is invalid';
            }
            if ($this->_request->getParam('status') != self::PAYMENT_PROCEEDED) {
                $order->getInvoiceCollection()->getFirstItem()->cancel()->save();
                $result['text'] = 'Payment canceled';
            }
            $order->getInvoiceCollection()->getFirstItem()->pay()->save();
            $result['text'] = 'Payment succeeded';
            return $result;
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            $result['code'] = self::SYSTEM_ERROR;
            $result['text'] = $e->getMessage();
            return $result;
        } catch (Exception $e) {
            Mage::logException($e);
            $result['code'] = self::SYSTEM_ERROR;
            $result['text'] = 'System crash';
            return $result;
        }
    }

}