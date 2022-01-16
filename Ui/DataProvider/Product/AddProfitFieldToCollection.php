<?php
/**
 * Yogesh Suhagiya
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future. If you wish to customize this module for your needs.
 * Please contact Yogesh Suhagiya (yksuhagiya@gmail.com)
 *
 * @category    Practical
 * @package     Practical_EstimateProfit
 * @author      Yogesh Suhagiya (yksuhagiya@gmail.com)
 * @copyright   Copyright (c) 2022
 * @license     https://github.com/yogeshsuhagiya/estimate-profit/blob/main/LICENSE
 */
namespace Practical\EstimateProfit\Ui\DataProvider\Product;

/**
 * Class AddProfitFieldToCollection
 */
class AddProfitFieldToCollection implements \Magento\Ui\DataProvider\AddFieldToCollectionInterface
{

    /**
     * @var int
     */
    protected $typeId;

    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $config;

    /**
     * AddProfitFieldToCollection constructor
     * 
     * @param \Magento\Eav\Model\Config $config
     */
    public function __construct(\Magento\Eav\Model\Config $config)
    {
        $this->config = $config;
        $this->typeId = $config->getEntityType(\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE)->getEntityTypeId();
    }

    /**
     * Customize collection query to add custom field column and provide data
     */
    public function addField(\Magento\Framework\Data\Collection $collection, $field, $alias = null)
    {

        // \Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE
        $collection->getSelect()->joinLeft(
            ['ea1' => 'eav_attribute'],
            "ea1.entity_type_id = $this->typeId AND ea1.attribute_code = 'price'"
        );

        $collection->getSelect()->joinLeft(
            ['cped1' => 'catalog_product_entity_decimal'],
            'e.entity_id = cped1.entity_id AND ea1.attribute_id = cped1.attribute_id'
        );

        $collection->getSelect()->joinLeft(
            ['ea2' => 'eav_attribute'],
            "ea2.entity_type_id = $this->typeId AND ea2.attribute_code = 'special_price'"
        );

        $collection->getSelect()->joinLeft(
            ['cped2' => 'catalog_product_entity_decimal'],
            'e.entity_id = cped2.entity_id AND ea2.attribute_id = cped2.attribute_id'
        );

        $collection->getSelect()->joinLeft(
            ['ea3' => 'eav_attribute'],
            "ea3.entity_type_id = $this->typeId AND ea3.attribute_code = 'cost'"
        );

        $collection->getSelect()->joinLeft(
            ['cped3' => 'catalog_product_entity_decimal'],
            'e.entity_id = cped3.entity_id AND ea3.attribute_id = cped3.attribute_id',
            ['estimate_profit' => new \Zend_Db_Expr("IF(cped3.value IS NOT NULL, IF(cped2.value IS NOT NULL AND cped2.value > 0, cped2.value-cped3.value, cped1.value-cped3.value), '0')")]
        );
    }
}
