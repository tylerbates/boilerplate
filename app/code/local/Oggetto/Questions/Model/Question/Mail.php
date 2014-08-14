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
 * Questions mailer model
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Model_Question_Mail
{
    const XML_PATH_EMAIL_SENDER     = 'contacts/questions/sender';
    const XML_PATH_EMAIL_TEMPLATE   = 'questions/email/template';

    /**
     * Send email
     *
     * @param Oggetto_Questions_Model_Question $question Question to send
     * @return void
     */
    public function send($question)
    {
        $emailTemplate = Mage::getModel('core/email_template');
        $emailTemplate->setDesignConfig(['area' => 'frontend'])
            ->sendTransactional(
                Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                $question->getEmail(),
                null,
                ['question' => $question]
            );
        if (!$emailTemplate->getSentSuccess()) {
            Mage::throwException(Mage::helper('questions')->__('Unable to send email'));
        }
    }
}