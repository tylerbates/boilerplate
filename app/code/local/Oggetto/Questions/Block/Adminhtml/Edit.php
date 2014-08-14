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
 * Adminhtml Questions form container
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Block
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Prepare form data
     *
     * @return Oggetto_Questions_Block_Adminhtml_Edit
     */
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_mode = 'edit';
        $this->_blockGroup = 'questions';
        $this->_controller = 'adminhtml';

        parent::__construct();

        $this->_removeButton('reset');
    }

    /**
     * Get current question
     *
     * @return Oggetto_Questions_Model_Question
     */
    public function getQuestion()
    {
        return Mage::registry('current_question');
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('questions')->__("Edit question #%s", $this->getQuestion()->getId());
    }
}