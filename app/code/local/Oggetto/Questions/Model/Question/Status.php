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
 * Question status model
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */
class Oggetto_Questions_Model_Question_Status
{
    const NOT_ANSWERED = 0;

    const ANSWERED = 1;

    /**
     * get statuses hash
     *
     * @return array
     */
    public function getStatusHash()
    {
        $helper = Mage::helper('questions');
        return [
            self::NOT_ANSWERED => $helper->__('Not answered'),
            self::ANSWERED => $helper->__('Answered')
        ];
    }
}