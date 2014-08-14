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
 * the Oggetto Questionsy module to newer versions in the future.
 * If you wish to customize the Oggetto Questions module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Questions model
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Model_Question extends Mage_Core_Model_Abstract
{
    /**
     * initialize model
     *
     * @return Oggetto_Questions_Model_Question
     */
    protected function _construct()
    {
        $this->_init('questions/question');
    }

    /**
     * Set creation date before saving question
     *
     * @return Oggetto_Questions_Model_Question
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if ($this->isObjectNew()) {
            $this->setCreatedAt(Mage::getModel('core/date')->gmtDate());
            if (!$this->hasAnswer()) {
                $this->setStatus(Oggetto_Questions_Model_Question_Status::NOT_ANSWERED);
            } else {
                $this->setStatus(Oggetto_Questions_Model_Question_Status::ANSWERED);
                $this->_sendEmail();
            }
        } else {
            if (
                $this->getStatus() == Oggetto_Questions_Model_Question_Status::ANSWERED &&
                !$this->getEmailSent()
            ) {
                $this->_sendEmail();
            }
        }
        return $this;
    }

    /**
     * Send email to user if his question answered
     *
     * @return void
     */
    private function _sendEmail()
    {
        $this->setEmailSent(1);
        Mage::getModel('questions/question_mail')->send($this);
    }
}