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
 * Article resource collection
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_News_Model_Resource_Article_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    const IDX_TABLE = 'news/article_category_idx';
    const CATEGORY_TABLE = 'news/category';

    /**
     * Define resource model and model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('news/article');
    }

    /**
     * Order collection by creation date
     *
     * @return Oggetto_News_Model_Resource_Article_Collection
     */
    public function sorted()
    {
        $this->setOrder('created_at', 'DESC');
        return $this;
    }
    
    /**
     * Sort collection by 'active' field
     * 
     * @return Oggetto_News_Model_Resource_Article_Collection
     */
    public function active()
    {
        $this->addFieldToFilter('active', ['eq' => 1]);
        return $this;
    }

    /**
     * filter articles by category id
     *
     * @param int $categoryId Category Id
     * @return Oggetto_News_Model_Resource_Article_Collection
     */
    public function filterByCategory($categoryId)
    {
        $this->_select->joinLeft(
            ['idx' => $this->getTable(self::IDX_TABLE)],
            'main_table.entity_id = idx.article_id',
            []
        );
        $this->_select->joinLeft(
            ['category' => $this->getTable(self::CATEGORY_TABLE)],
            'category.entity_id = idx.category_id',
            []
        );
        $this->_select->where('idx.category_id = ?', $categoryId);
        return $this;
    }
}