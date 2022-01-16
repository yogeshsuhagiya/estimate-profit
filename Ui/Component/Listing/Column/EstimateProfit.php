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
namespace Practical\EstimateProfit\Ui\Component\Listing\Column;

use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Practical\EstimateProfit\Helper\Config;
use Practical\EstimateProfit\Helper\Calculate;

/**
 * Class EstimateProfit
 */
class EstimateProfit extends Column
{

    /**
     * UI component factory
     *
     * @var UiComponentFactory
     */
    protected $uiComponentFactory;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Calculate
     */
    protected $calculate;

    /**
     * EstimateProfit constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param Config $config
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        Config $config,
        Calculate $calculate
    ) {

        $this->uiComponentFactory = $uiComponentFactory;
        $this->config = $config;
        $this->calculate = $calculate;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function prepare()
    {
        $this->_data['config']['componentDisabled'] = !$this->config->showEstimatedProfit();
        parent::prepare();
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if ($this->config->isEnable()) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$fieldName])) {
                    $qty = $item['qty'];
                    $profit = $item[$fieldName] * $qty;
                    $item[$fieldName] = !empty($profit) ? $this->calculate->getFormatedPrice($profit) : '';
                }
            }
        }
        return $dataSource;
    }

    /**
     * Apply sorting
     *
     * @return void
     */
    protected function applySorting()
    {
        $sorting = $this->getContext()->getRequestParam('sorting');
        $isSortable = $this->getData('config/sortable');
        if (
            $isSortable !== false
            && !empty($sorting['field'])
            && !empty($sorting['direction'])
            && $sorting['field'] === $this->getName()
        ) {
            $this->getContext()->getDataProvider()->addOrder(
                new \Zend_Db_Expr("IF(cped3.value IS NOT NULL, IF(cped2.value IS NOT NULL AND cped2.value > 0, cped2.value-cped3.value, cped1.value-cped3.value), '0')"),
                strtoupper($sorting['direction'])
            );
        }
    }
}