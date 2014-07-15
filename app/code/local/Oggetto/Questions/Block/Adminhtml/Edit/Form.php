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
 * Adminhtml Questions edit form
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Block
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form action
     *
     * @return Oggetto_Questions_Block_Adminhtml_Edit_Form
     */
    protected function _prepareForm()
    {
        $question = $this->_getQuestion();

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_question', array(
            'legend' => Mage::helper('questions')->__('Question Details')
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');

        $fieldset->addField('name', 'text', [
            'label' => Mage::helper('questions')->__('Customer Name'),
            'name' => 'name'
        ]);

        $fieldset->addField('email', 'text', [
            'label' => Mage::helper('questions')->__('Customer Email'),
            'name' => 'email'
        ]);

        if ($this->_getQuestion()->getId()) {
            $fieldset->addField('created_at', 'label', [
                'label' => Mage::helper('questions')->__('Creation Date'),
            ]);
        }

        $fieldset->addField('status', 'select', [
            'name'   => 'status',
            'label'  => Mage::helper('questions')->__('Status'),
            'values' => Mage::getModel('questions/question_status')->getStatusHash()
        ]);

        $fieldset->addField('question', 'editor', array(
            'name'     => 'question',
            'style'    => 'height:12em;width:50em;',
            'required' => false,
            'label'    => Mage::helper('questions')->__('Question'),
            'config'   => $wysiwygConfig
        ));

        $fieldset->addField('answer', 'editor', array(
            'name'     => 'answer',
            'style'    => 'height:12em;width:50em;',
            'required' => false,
            'label'    => Mage::helper('questions')->__('Answer'),
            'config'   => $wysiwygConfig
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setEnctype('multipart/form-data');
        $form->setAction($this->getUrl('*/*/save', array('entity_id' => $this->_getQuestion()->getId())));
        $form->setValues($this->_prepareValues($question));

        $this->setForm($form);
    }

    /**
     * get question item
     *
     * @return Oggetto_Questions_Model_Question
     */
    private function _getQuestion()
    {
        return Mage::registry('current_question');
    }

    /**
     * Prepare form values
     *
     * @param Oggetto_Questions_Model_Question $question Question
     * @return array
     */
    protected function _prepareValues($question)
    {
        $data = $question->getData();
        if (isset($data['created_at'])) {
            $data['created_at'] = Mage::app()->getLocale()->storeDate(
                Mage::app()->getStore('default'),
                Varien_Date::toTimestamp($data['created_at']),
                true
            )->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        }
        return $data;
    }
}