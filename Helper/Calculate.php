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
namespace Practical\EstimateProfit\Helper;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Directory\Model\Currency;

/**
 * Class Calculate
 */
class Calculate
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $cost;

    /**
     * @var int
     */
    private $qty;

    /**
     * @var float
     */
    private $profit;

    /**
     * @var PriceCurrencyInterface $priceCurrency
     */
    protected $priceCurrency;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * Calculate constructor.
     *
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        Currency $currency,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->currency = $currency;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Get Sale Price
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get actual cost
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Get Salable Qty
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Get Estimated Profit
     * @return float
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Check weather module is enable or not
     */
    public function execute($price, $cost, $qty)
    {
        $profit = 0;

        if (!empty($cost) && $cost > 0) {
            $profit = ($price - $cost) * $qty;
        }

        return $this->setData([
            'price' => $price,
            'cost' => $cost,
            'qty' => $qty,
            'profit' => $profit
        ]);
    }

    /**
     * Set all data and bind with helper class
     */
    public function setData($data)
    {
        $this->price = $this->getFormatedPrice($data['price']);
        $this->cost = $this->getFormatedPrice($data['cost']);
        $this->qty = $data['qty'];
        $this->profit = $this->getFormatedPrice($data['profit']);

        return $this;
    }

    /**
     * Convert number into currency format
     *
     * @param float $price
     * @return string
     */
    public function getFormatedPrice($price)
    {
        return strip_tags(
            $this->priceCurrency->convertAndFormat($price)
        );
    }

    /**
     * Remove currency symbol from price
     *
     * @param float $price
     * @return string
     */
    public function removeCurrency($price)
    {
        return $this->currency->format(
            $price,
            ['display' => \Zend_Currency::NO_SYMBOL],
            false
        );
    }
}
