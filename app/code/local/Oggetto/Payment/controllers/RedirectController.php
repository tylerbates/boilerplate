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
 * Payment redirect controller
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage controllers
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Payment_RedirectController extends Mage_Core_Controller_Front_Action
{
    /**
     * redirect action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $order = Mage::getSingleton('checkout/session')->getLastRealOrder();
        $this->getLayout()->getBlock('redirect_form')->setOrder($order);
        $this->renderLayout();
    }

    /**
     * Success action
     *
     * @return void
     */
    public function successAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Fail action
     *
     * @return void
     */
    public function failAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}