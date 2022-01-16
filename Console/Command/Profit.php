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
namespace Practical\EstimateProfit\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Profit
 */
class Profit extends Command
{

    /**
     * Field name for argument
     */
    const ARGUMENT = 'id';

    /**
     * @var \Practical\EstimateProfit\Helper\Config
     */
    private $config;

    /**
     * @var \Practical\EstimateProfit\Model\Product\Profit
     */
    private $profit;

    /**
     * Profit constructor.
     *
     * @param \Practical\EstimateProfit\Helper\Config $config
     * 
     * @throws LogicException When the command name is empty
     */
    public function __construct(
        \Practical\EstimateProfit\Helper\Config $config,
        \Practical\EstimateProfit\Model\Product\Profit $profit
    ) {
        $this->config = $config;
        $this->profit = $profit;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('salecto:product:profit')
            ->setDescription('This is my first console command.')
            ->setDefinition([
                new InputArgument(
                    self::ARGUMENT,
                    InputArgument::REQUIRED,
                    __('The product for which you want to calculate the estimated profit (eg: 123). Can be a product Id.')
                )
            ]);

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->config->isEnable()) {
            throw new \Exception(__("Enable First !! Goto: STORES > Configuration > Practical By Yogesh > General Settings"));
        }

        if ($id = $input->getArgument(self::ARGUMENT)) {
            $output->writeln('<info>Provided product ID is `' . $id . '`</info>');
        }
        
        if (empty($id)) {
            throw new \Exception(__("The Product ID cannot be empty"));
        }

        $helper = $this->profit->getEstimateProfit($id);

        $output->writeln('------------------------------');
        $output->writeln('<info>Sale Price = `' . $helper->getPrice() . '`</info>');
        $output->writeln('<info>Cost Price = `' . $helper->getCost() . '`</info>');
        $output->writeln('<info>Salable Qty = `' . $helper->getQty() . '`</info>');
        $output->writeln('------------------------------');
        $output->writeln('<info>Estimated Price = `' . $helper->getProfit() . '`</info>');
        $output->writeln('------------------------------');
    }
}
