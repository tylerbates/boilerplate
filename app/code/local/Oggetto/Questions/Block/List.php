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
 * Questions list block
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Block
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Block_List extends Mage_Core_Block_Template
{
    /** @var Oggetto_Questions_Model_Resource_Question_Collection */
    private $_collection;

    /**
     * Set uo collection on load
     *
     * @return Oggetto_Questions_Block_List
     */
    public function __construct()
    {
        parent::__construct();
        $this->_collection = Mage::getModel('questions/question')
            ->getCollection()
            ->addFieldToFilter('status', ['eq' => Oggetto_Questions_Model_Question_Status::ANSWERED]);
    }

    /**
     * Get collection of questions
     *
     * @return Oggetto_Questions_Model_Resource_Question_Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

    /**
     * add pagination
     *
     * @return Oggetto_Questions_Block_List
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'questions.pager');
        $pager->setAvailableLimit(array(5=>5));
        $pager->setShowAmounts(false);
        $pager->setCollection($this->getCollection());

        $this->setChild('pager', $pager);

        return $this;
    }

    /**
     * Get pager html
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}