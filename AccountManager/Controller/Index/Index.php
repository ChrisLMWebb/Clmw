<?php

namespace Clmw\AccountManager\Controller\Index;

use \Magento\Framework\Event\Observer;
//use Magento\Framework\App\Action\Action;
use Clmw\AccountManager\Observer\ExampleController;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends Action
{


    public function __construct(ManagerArray $managerArray, LastSaleData $lastSaleData, ScopeConfigInterface $scopeConfig)
    {
        $this->managerArray = $managerArray;
        $this->lastSaleData = $lastSaleData;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Success from example.');

        echo('Loaded');


        $managers = $this->managerArray->getManagerArray();
        $lastSale = $this->lastSaleData->getLastSaleData();

        $lastSaleAmount = floatval($lastSale["base_grand_total"]) * 100; //In cents.
        $lastSaleAddress = $lastSale["shipping_address"];

        $managers = $this->managerArray->getManagerArray();
        $lastSale = $this->lastSaleData->getLastSaleData();

        $lastSaleAmount = floatval($lastSale["base_grand_total"]) * 100; //In cents.
        $lastSaleAddress = $lastSale["shipping_address"];


        if ($lastSaleAmount > $this->getConfigValue()) {
            foreach ($managers as $val) {
                $province = $val['province'];
                $managerId = $val['manager_id'];
                $managerName = $val['manager_name'];

                if (strpos($lastSaleAddress, $province) !== false) {
                    $this->assignManager($province, $managerId, $managerName); //Pass to function.
                }
            }
        }
    }
}
