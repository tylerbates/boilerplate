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
 * Adminhtml Questions grid
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage Block
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Block_Adminhtml_Questions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set up
     *
     * @return Oggetto_Questions_Block_Adminhtml_Questions_Grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('questionsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('questions/question')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add questions delete mass action
     *
     * @return object
     */
    protected function _prepareMassAction()
    {
        parent::_prepareMassaction();
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entities');
        $this->getMassactionBlock()->addItem('questionsDelete', [
                'label' => Mage::helper('questions')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('questions')->__('Are you sure?')
            ]
        );
        $statuses = Mage::getModel('questions/question_status')->getStatusHash();

        $this->getMassactionBlock()->addItem('questionsStatusChange', [
            'label' => Mage::helper('questions')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatusChange'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('catalog')->__('Status'),
                    'values' => $statuses
                )
            ),
            'confirm' => Mage::helper('questions')->__('Are you sure?')
        ]);
    }

    /**
     * Prepare columns
     *
     * @return void
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'type'   => 'number',
            'header' => Mage::helper('questions')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'entity_id',
        ));
        $this->addColumn('name', array(
            'header' => Mage::helper('questions')->__('Customer Name'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'name',
        ));
        $this->addColumn('email', array(
            'header' => Mage::helper('questions')->__('Customer Email'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'email',
        ));
        $this->addColumn('created_at', array(
            'type'   => 'datetime',
            'header' => Mage::helper('questions')->__('Creation Date'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'created_at',
            'renderer' => 'questions/adminhtml_questions_grid_date'
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('questions')->__('Status'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getModel('questions/question_status')->getStatusHash()
        ));
    }

    /**
     * Get url for grid row
     *
     * @param Varien_Object $row Row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}