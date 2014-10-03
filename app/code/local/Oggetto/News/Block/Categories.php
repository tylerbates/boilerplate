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
 * Categories block
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_News_Block_Categories extends Mage_Core_Block_Template
{
    /**
     * @var Oggetto_News_Model_Resource_Category
     */
    private $_category = null;

    /**
     * retrieve current category
     *
     * @return Oggetto_News_Model_Resource_Category
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * Get child Category html
     *
     * @param Oggetto_News_Model_Resource_Category $category Category
     * @return string
     */
    public function getChildCategoryHtml($category)
    {
        $this->_category = $category;
        return $this->toHtml();
    }

    /**
     * Get root categories for upper level
     *
     * @return Oggetto_News_Model_Resource_Category_Collection
     */
    public function getRootCategories()
    {
        return Mage::getModel('news/category')->getCollection()->filterByParent();
    }
}