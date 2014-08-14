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
    $regionTable = $installer->getTable('directory/country_region');
    $regionNameTable = $installer->getTable('directory/country_region_name');

    $regions = array(
        array("Москва", "MOW", ""),
        array("Санкт-Петербург", "SPE", ""),
        array("Республика Адыгея", "AD", "respublika-adygeja"),
        array("Республика Башкортостан", "BA", "respublika-bashkortostan"),
        array("Республика Бурятия", "BU", "respublika-burjatija"),
        array("Республика Алтай", "AL", "respublika-altaj"),
        array("Республика Дагестан", "DA", "respublika-dagestan"),
        array("Республика Ингушетия", "IN", "respublika-ingushetija"),
        array("Кабардино-Балкарская республика", "KB", "kabardino-balkarskaja-respublika"),
        array("Республика Калмыкия", "KL", "respublika-kalmykija"),
        array("Карачаево-Черкесская республика", "KC", "karachaevo-cherkesskaja-respublika"),
        array("Республика Карелия", "KR", "respublika-karelija"),
        array("Республика Коми", "KO", "respublika-komi"),
        array("Республика Марий Эл", "ME", "respublika-marij-el"),
        array("Республика Мордовия", "MO", "respublika-mordovija"),
        array("Республика Саха (Якутия)", "SA", "respublika-saha-yakutija"),
        array("Республика Северная Осетия — Алания", "SE", "respublika-sev.osetija-alanija"),
        array("Республика Татарстан", "TA", "respublika-tatarstan"),
        array("Республика Тыва", "TY", "respublika-tyva"),
        array("Удмуртская республика", "UD", "udmurtskaja-respublika"),
        array("Республика Хакасия", "KK", "respublika-khakasija"),
        array("Чеченская республика", "CE", "chechenskaya-respublika"),
        array("Чувашская республика", "CU", "chuvashskaja-respublika"),
        array("Алтайский край", "ALT", "altajskij-kraj"),
        array("Забайкальский край", "ZAB", "zabajkalskij-kraj"),
        array("Камчатский край", "KAM", "kamchatskij-kraj"),
        array("Краснодарский край", "KDA", "krasnodarskij-kraj"),
        array("Красноярский край", "KYA", "krasnojarskij-kraj"),
        array("Пермский край", "PER", "permskij-kraj"),
        array("Приморский край", "PRI", "primorskij-kraj"),
        array("Ставропольский край", "STA", "stavropolskij-kraj"),
        array("Хабаровский край", "KHA", "khabarovskij-kraj"),
        array("Амурская область", "AMU", "amurskaja-oblast"),
        array("Архангельская область", "ARK", "arhangelskaja-oblast"),
        array("Астраханская область", "AST", "astrahanskaja-oblast"),
        array("Белгородская область", "BEL", "belgorodskaja-oblast"),
        array("Брянская область", "BRY", "brjanskaja-oblast"),
        array("Владимирская область", "VLA", "vladimirskaja-oblast"),
        array("Волгоградская область", "VGG", "volgogradskaja-oblast"),
        array("Вологодская область", "VLG", "vologodskaja-oblast"),
        array("Воронежская область", "VOR", "voronezhskaja-oblast"),
        array("Ивановская область", "IVA", "ivanovskaja-oblast"),
        array("Иркутская область", "IRK", "irkutskaja-oblast"),
        array("Калининградская область", "KGD", "kaliningradskaja-oblast"),
        array("Калужская область", "KLU", "kaluzhskaja-oblast"),
        array("Кемеровская область", "KEM", "kemerovskaja-oblast"),
        array("Кировская область", "KIR", "kirovskaja-oblast"),
        array("Костромская область", "KOS", "kostromskaja-oblast"),
        array("Курганская область", "KGN", "kurganskaja-oblast"),
        array("Курская область", "KRS", "kurskaja-oblast"),
        array("Ленинградская область", "LEN", "leningradskaja-oblast"),
        array("Липецкая область", "LIP", "lipeckaja-oblast"),
        array("Магаданская область", "MAG", "magadanskaja-oblast"),
        array("Московская область", "MOS", "moskovskaja-oblast"),
        array("Мурманская область", "MUR", "murmanskaja-oblast"),
        array("Нижегородская область", "NIZ", "nizhegorodskaja-oblast"),
        array("Новгородская область", "NGR", "novgorodskaja-oblast"),
        array("Новосибирская область", "NVS", "novosibirskaja-oblast"),
        array("Омская область", "OMS", "omskaja-oblast"),
        array("Оренбургская область", "ORE", "orenburgskaja-oblast"),
        array("Орловская область", "ORL", "orlovskaja-oblast"),
        array("Пензенская область", "PNZ", "penzenskaja-oblast"),
        array("Псковская область", "PSK", "pskovskaja-oblast"),
        array("Ростовская область", "ROS", "rostovskaja-oblast"),
        array("Рязанская область", "RYA", "rjazanskaja-oblast"),
        array("Самарская область", "SAM", "samarskaja-oblast"),
        array("Саратовская область", "SAR", "saratovskaja-oblast"),
        array("Сахалинская область", "SAK", "sahalinskaja-oblast"),
        array("Свердловская область", "SVE", "sverdlovskaja-oblast"),
        array("Смоленская область", "SMO", "smolenskaja-oblast"),
        array("Тамбовская область", "TAM", "tambovskaja-oblast"),
        array("Тверская область", "TVE", "tverskaja-oblast"),
        array("Томская область", "TOM", "tomskaja-oblast"),
        array("Тульская область", "TUL", "tulskaja-oblast"),
        array("Тюменская область", "TYU", "tjumenskaja-oblast"),
        array("Ульяновская область", "ULY", "uljanovskaja-oblast"),
        array("Челябинская область", "CHE", "cheljabinskaja-oblast"),
        array("Ярославская область", "YAR", "yaroslavskaja-oblast"),
        array("Еврейская автономная область", "YEV", "evrejskaja-ao"),
        array("Ненецкий автономный округ", "NEN", "neneckij-ao"),
        array("Ханты-Мансийский автономный округ - Югра", "KHM", "khanty-mansijskij-ao"),
        array("Чукотский автономный округ", "CHU", "chukotskij-ao"),
        array("Ямало-Ненецкий автономный округ", "YAN", "yamalo-neneckij-ao"),
    );

    $adapter->beginTransaction();

    foreach ($regions as $regionData) {
        $name    = $regionData[0];
        $isoCode = $regionData[1];
        $defaultName = $regionData[2];

        $adapter->insert($regionTable, [
            'country_id' => 'RU',
            'code' => $isoCode,
            'default_name' => $defaultName
        ]);

        $adapter->insert($regionNameTable, [
            'locale' => 'ru_RU',
            'region_id' => $adapter->lastInsertId(),
            'name' => $name
        ]);
    }

    $adapter->commit();

} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();