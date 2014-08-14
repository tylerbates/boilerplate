<?php
/**
 * PHP Unit test suite for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev_PHPUnit
 * @copyright  Copyright (c) 2013 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

interface EcomDev_PHPUnit_Model_Yaml_Loader_Interface
{
    /**
     * Resolves YAML file path based on its filename,
     * if file is not found, it should return false
     *
     * @param string $fileName name of the file
     * @param string $relatedClassName class name from which load of yaml file is invoked
     * @param string $type type of Yaml file (provider, fixture, expectation)
     * @return string|bool
     */
    public function resolveFilePath($fileName, $relatedClassName, $type);
}