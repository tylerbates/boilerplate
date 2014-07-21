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
 * Questions helper
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Helper_Data extends Mage_Core_Helper_Abstract
{
    /** @var Oggetto_Questions_Model_Resource_Question_Collection */
    private $_collection;

    /**
     * Set up collection on load
     *
     * @return Oggetto_Questions_Helper_Data
     */
    public function __construct()
    {
        $this->_collection = Mage::getModel('questions/question')
            ->getCollection()
            ->addFieldToFilter('status', ['eq' => Oggetto_Questions_Model_Question_Status::ANSWERED]);
    }

    /**
     * get Questions Url
     *
     * @return string
     */
    public function geturl()
    {
        return $this->_getUrl('questions');
    }

    /**
     * get page limits for questions list
     *
     * @return array
     */
    public function getPageLimits()
    {
        return [5 => 5];
    }

    /**
     * Get collection for pager
     *
     * @return Oggetto_Questions_Model_Resource_Question_Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

    /**
     * get Show Amounts
     *
     * @return array
     */
    public function getShowAmounts()
    {
        return ['show_amounts' => false];
    }
}