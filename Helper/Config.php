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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 */
class Config
{

    /**
     * Config path for module enable field
     */
    const XML_PATH_ENABLE = 'practical/general/enable';

    /**
     * Config path to show column "Estimated Profit" on product grid
     */
    const XML_PATH_ESTIMATE_PROFIT = 'practical/general/estimate_profit';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check weather module is enable or not
     */
    public function isEnable()
    {
        $store = ScopeInterface::SCOPE_STORE;
        $value = $this->scopeConfig->getValue(self::XML_PATH_ENABLE, $store);
        if (!empty($value)) {
            return true;
        }
        return false;
    }

    /**
     * Check weather module is enable or not
     */
    public function showEstimatedProfit()
    {
        if ($this->isEnable()) {
            $store = ScopeInterface::SCOPE_STORE;
            $value = $this->scopeConfig->getValue(self::XML_PATH_ESTIMATE_PROFIT, $store);
            if (!empty($value)) {
                return true;
            }
        }

        return false;
    }
}
