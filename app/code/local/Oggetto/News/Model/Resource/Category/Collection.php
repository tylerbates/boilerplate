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
 * the Oggetto News module to newer versions in the future.
 * If you wish to customize the Oggetto News module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Article category collection
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_News_Model_Resource_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model and model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('news/category');
    }

    /**
     * Filter collection for zero parent
     *
     * @param Oggetto_News_Model_Category $parent Parent category
     * @return Oggetto_News_Model_Resource_Category_Collection
     */
    public function filterByParent($parent = null)
    {
        $parentId = $parent ? $parent->getId() : 0;
        $this->addFieldToFilter('parent_id', ['eq' => $parentId]);
        $this->setOrder('sort_order', Varien_Data_Collection::SORT_ORDER_ASC);
        return $this;
    }
}