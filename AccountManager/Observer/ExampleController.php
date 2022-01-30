<?php

namespace Clmw\AccountManager\Observer;

use \Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Clmw\AccountManager\Model\GetSalesDataFactory;
use Clmw\AccountManager\Model\SetSalesManagerFactory;
use Clmw\AccountManager\Model\ManagerDatabaseFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResourceConnection;

//use Magento\Framework\ObjectManager\ObjectManager;

class ExampleController
{
    public $modelManagerDBFactory;
    public $modelGetSalesDataFactory;
    public $modelSetSalesManagerFactory;
    public $messageManager;
    public $resource;
    public $connection;
    public $storeManager;

    public function __construct(
        Context                $context,
        GetSalesDataFactory    $modelGetSalesDataFactory,
        ManagerDatabaseFactory $modelManagerDBFactory,
        SetSalesManagerFactory $modelSetSalesManagerFactory,
        StoreManagerInterface  $storeManager,
        ManagerInterface       $messageManager,
        ResourceConnection     $resource
    ) {
        parent::__construct($context);
        $this->modelGetSalesDataFactory = $modelGetSalesDataFactory; //This is used to get latest sales data.
        $this->modelManagerDBFactory = $modelManagerDBFactory; //This is used to get array of provincial managers.
        $this->modelSetSalesManagerFactory = $modelSetSalesManagerFactory; //This is used to write to sales_manager_mapping.
        $this->storeManager = $storeManager; //WHY IS THIS HERE???
        $this->messageManager = $messageManager;
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
    }


    //Returns array of provincial managers stored in account_manager_array.
    public function getManagerArray(){
        $managerDatabaseModel = $this->modelManagerDBFactory->create();
        $managerDatabaseCollection = $managerDatabaseModel->getCollection();
        $managerArray = $managerDatabaseCollection->getData();
        return $managerArray;
    }

    //Returns entity_id and region of most recent entry to sales_order_grid.
    public function getLastSaleData(){
        $getSalesDataModel = $this->modelGetSalesDataFactory->create();
        $getSalesDataCollection = $getSalesDataModel->getCollection();
        $myArray = $getSalesDataCollection->getData();
        $lastEl = array_values(array_slice($myArray, -1))[0];
        $lastSaleData = array_intersect_key($lastEl, array_flip(array('entity_id', 'base_grand_total', 'shipping_name', 'shipping_address')));;
        return $lastSaleData;
    }


    public function insertMultiple($table, $data)
    {
        $tableName = $this->resource->getTableName($table);
        return $this->connection->insertMultiple($tableName, $data);
    }
    public function assignManager($province, $managerId, $managerName)
    {
        $tableName = 'sales_manager_mapping';

        $data = [
            'order_id' => $this->getLastSaleData()["entity_id"],
            'customer_name' => $this->getLastSaleData()["shipping_name"],
            'province' => $province,
            'manager_id' => $managerId,
            'manager_name' => $managerName,
        ];

        $this->insertMultiple($tableName, $data);

    }
    public function execute()
    {
        $managerArray = $this->getManagerArray();
        $lastSale = $this->getLastSaleData();

        $lastSaleAmount = floatval($lastSale["base_grand_total"]) * 100; //In cents.
        $lastSaleAddress = $lastSale["shipping_address"];


        if ($lastSaleAmount > $this->getConfigValue()) {
            foreach ($managerArray as $val) {
                $province = $val['province'];
                $managerId = $val['manager_id'];
                $managerName = $val['manager_name'];

                if (strpos($lastSaleAddress, $province) !== false) {
                    $this->assignManager($province, $managerId, $managerName);
                }
            }
        }
    }
}
