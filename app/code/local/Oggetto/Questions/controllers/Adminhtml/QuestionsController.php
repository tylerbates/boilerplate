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
 * Adminhtml Questions controller
 *
 * @category   Oggetto
 * @package    Oggetto_Questions
 * @subpackage controllers
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_Questions_Adminhtml_QuestionsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Grid action for filtering and sorting
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Edit question
     *
     * @return void
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $question = Mage::getModel('questions/question')->load($id);
        if ($question->getId()) {
            Mage::register('current_question', $question);
            $this->loadLayout();
            $this->renderLayout();
        } else {
            Mage::getSingleton('core/session')->addError('Question not found');
            $this->_redirectReferer();
        }

    }

    /**
     * Create new question
     *
     * @return void
     */
    public function newAction()
    {
        $question = Mage::getModel('questions/question');
        Mage::register('current_question', $question);
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Save question
     *
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $id = $this->getRequest()->getParam('entity_id');
        $question = Mage::getModel('questions/question')->load($id);
        try {
            $question->addData($data)
                ->save();
            $this->_getSession()->addSuccess(Mage::helper('questions')->__('Question successfully saved'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            Mage::logException($e);
        } catch (Exception $e) {
            $this->_getSession()->addError(Mage::helper('questions')->__('An error occured while saving question'));
            Mage::logException($e);
        }
        $this->_redirect('*/*/index');
    }

    /**
     * delete Question
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $question = Mage::getModel('questions/question')->load($id);
        if (!$question->getId()) {
            $this->_getSession()->addError(Mage::helper('questions')->__('Question not found'));
            $this->_redirectReferer();
        } else {
            try {
                $question->delete();
                $this->_getSession()->addSuccess(Mage::helper('questions')->__('Question successfully deleted'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('questions')->__('An error occured while deleting question'));
                Mage::logException($e);
            }
            $this->_redirect('*/*/index');
        }
    }

    /**
     * delete range of questions
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $entities = $this->getRequest()->getPost('entities');
        $hasError = false;
        foreach ($entities as $entityId) {
            $question = Mage::getModel('questions/question')->load($entityId);
            if (!$question->getId()) {
                $hasError = true;
                $this->_getSession()->addError(Mage::helper('questions')->__('Question #%s not found', $entityId));
            } else {
                try {
                    $question->delete();
                } catch (Mage_Core_Exception $e) {
                    $hasError = true;
                    $this->_getSession()->addError($e->getMessage());
                    Mage::logException($e);
                } catch (Exception $e) {
                    $hasError = true;
                    $this->_getSession()->addError(Mage::helper('questions')->__('An error occured while deleting questions'));
                    Mage::logException($e);
                }
            }
        }

        if (!$hasError) {
            $this->_getSession()->addSuccess(Mage::helper('questions')->__('Questions successfully deleted'));
        }

        $this->_redirectReferer();
    }

    /**
     * change status to range of questions
     *
     * @return void
     */
    public function massStatusChangeAction()
    {
        $entities = $this->getRequest()->getPost('entities');
        $status = $this->getRequest()->getPost('status');
        $hasError = false;
        foreach ($entities as $entityId) {
            $question = Mage::getModel('questions/question')->load($entityId);
            if (!$question->getId()) {
                $hasError = true;
                $this->_getSession()->addError(Mage::helper('questions')->__('Question #%s not found', $entityId));
            } else {
                try {
                    $question->setStatus($status)->save();
                } catch (Mage_Core_Exception $e) {
                    $hasError = true;
                    $this->_getSession()->addError($e->getMessage());
                    Mage::logException($e);
                } catch (Exception $e) {
                    $hasError = true;
                    $this->_getSession()->addError(Mage::helper('questions')->__('An error occured while changing statuses'));
                    Mage::logException($e);
                }
            }
        }

        if (!$hasError) {
            $this->_getSession()->addSuccess(Mage::helper('questions')->__('Questions statuses successfully updated'));
        }

        $this->_redirectReferer();
    }
}