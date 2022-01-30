<?php

namespace Clmw\AccountManager\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Clmw\AccountManager\Model\GetSalesDataFactory;


class Index extends Action
{
    /**
     * @var \Clmw\AccountManager\Model\GetSalesDataFactory
     */
    protected $_modelManagerDatabaseFactory;

    /**
     * @param Context $context
     * @param GetSalesDataFactory $modelGetSalesDataFactory
     */
    public function __construct(
        Context $context,
        GetSalesDataFactory $modelGetSalesDataFactory
    ) {
        parent::__construct($context);
        $this->_modelGetSalesDataFactory = $modelGetSalesDataFactory;
    }

    public function execute()
    {
        $getSalesDataModel = $this->_modelGetSalesDataFactory->create();

        // Load the item with ID is 1
        $item = $getSalesDataModel->load(1);
        var_dump($item->getData());

        // Get manager database collection
        $getSalesDataCollection = $getSalesDataModel->getCollection();
        // Load all data of collection
        //var_dump($managerDatabaseCollection->getData());



        echo("");


        print_r($getSalesDataCollection->getData());


    }
}
