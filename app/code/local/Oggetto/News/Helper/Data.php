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
 * news main helper
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Model
 * @author     Andrey Bugaev <abugaev@oggettoweb.com>
 */

class Oggetto_News_Helper_Data extends Mage_Core_Helper_Abstract
{
    /** @var Oggetto_News_Model_Resource_Article_Collection */
    private $_collection;

    /**
     * get page limits for articles list
     *
     * @return array
     */
    public function getPageLimits()
    {
        return [10 => 10];
    }

    /**
     * Get collection for pager
     *
     * @return Oggetto_News_Model_Resource_Article_Collection
     */
    public function getArticleCollection()
    {
        if (!$this->_collection) {
            $this->_collection = Mage::getModel('news/article')
                ->getCollection()
                ->active()
                ->sorted();
            if ($categoryId = Mage::registry('current_news_category')) {
                $this->_collection->filterBycategory($categoryId);
            }
        }
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