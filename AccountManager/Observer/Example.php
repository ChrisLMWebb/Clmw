<?php

namespace Clmw\AccountManager\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Example implements ObserverInterface
{
    public function Execute(Observer $observer
    )
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Plugin Ran after order placed');
    }
}
