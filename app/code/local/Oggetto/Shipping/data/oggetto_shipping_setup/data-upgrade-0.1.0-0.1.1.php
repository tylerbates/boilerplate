<?php
/**
 * Oggetto common Shipping stuff extension for Magento
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
 * the Oggetto Shipping module to newer versions in the future.
 * If you wish to customize the Oggetto Shipping module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @copyright  Copyright (C) 2014 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();
$adapter = $installer->getConnection();

try {
    $ratesTable = $installer->getTable('directory/currency_rate');

    $rates = $adapter->fetchAll($adapter->select()->from($ratesTable)->where('currency_to=?', 'RUB'));

    $adapter->beginTransaction();

    foreach ($rates as $ratesData) {
        $currencyTo    = $ratesData['currency_from'];
        $rate = 1 / $ratesData['rate'];

        $adapter->insert($ratesTable, [
            'currency_from' => 'RUB',
            'currency_to' => $currencyTo,
            'rate' => $rate
        ]);
    }

    $adapter->commit();

} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();