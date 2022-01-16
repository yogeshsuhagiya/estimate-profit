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
namespace Practical\EstimateProfit\Model\Product;

use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\Product;
use Practical\EstimateProfit\Helper\Calculate;

/**
 * Class Profit
 */
class Profit
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Calculate
     */
    protected $calculate;
	
    /**
     * Profit constructor.
     * 
     * @param ProductRepository $scopeConfig
     * @param Calculate $calculate
     */
	public function __construct(
		ProductRepository $productRepository,
        Calculate $calculate
	) {
		$this->productRepository = $productRepository;
        $this->calculate = $calculate;
	}

    /**
     * Get product data by Product Id
     */
    public function load($id)
	{
        try {
		    $product = $this->productRepository->getById($id);
            if ($product->getId()) {
                $this->product = $product;
            }
        } catch (\Exception $e) {
            throw new \Exception(__("Product with ID=$id does not exists"));
        }
	}

    /**
     * Collect require data for product to calculate estimated profit
     * 
     * @return \Practical\EstimateProfit\Helper\Calculate
     */
    public function getEstimateProfit($id)
    {
        $this->load($id);

        $salePrice = $this->product->getFinalPrice();
        $cost = $this->product->getCost();

        $stockItem = $this->product->getExtensionAttributes()->getStockItem();
        $qty = $stockItem->getQty();

        return $this->calculate->execute($salePrice, $cost, $qty);
    }
}
