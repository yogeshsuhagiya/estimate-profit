# Magento 2 - Estimate Profit [Yogesh Suhagiya](https://github.com/yogeshsuhagiya)
- Admin configurations to enable the module
- Settings for whether it should show estimated profit column on product grid or not
- An extra column to the product grid in the backend called "Estimated Profit"
- Estimated profit should be calculated as: (Sales price - Cost price) X Qty in stock
- If there is no cost price entered, then the estimated profit will be blank
- A console command: bin/magento salecto:product:profit [productId] which shows product's profit.
- You can upload to GIT once completed and send the link.

## **Prerequisite**
- Composer: 2.x
- PHP: 7.4
- Magento: 2.4

## **Installation** 
1. Composer Installation
      - Navigate to your Magento root folder<br />
            `cd path_to_the_magento_root_directory`
      - Then run the following command<br />
            `yogeshsuhagiya/estimate-profit`<br />
      - Make sure that composer finished the installation without errors

 2. Command Line Installation
      - Backup your web directory and database.
      - Download the latest installation package estimate-profit-vvvv.zip from [here](https://github.com/yogeshsuhagiya/estimate-profit/releases)
      - Navigate to your Magento root folder<br />
            `cd path_to_the_magento_root_directory`<br />
      - Upload contents of the installation package to your Magento root directory
      - Then run the following command<br />
            `php bin/magento module:enable Practical_EstimateProfit`<br />
   
- After install the extension, run the following command
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```
- Log out from the backend and login again.