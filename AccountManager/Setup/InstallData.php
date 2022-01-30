<?php

namespace Clmw\AccountManager\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class InstallData implements InstallDataInterface
{


    protected $_directoryList;

    public function __construct(\Magento\Framework\App\Filesystem\DirectoryList $directoryList){
        $this->_directoryList = $directoryList;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // Get app folder
        $filepath = $this->_directoryList->getRoot();

        $setup->startSetup();

        $tableName = $setup->getTable('account_manager_mapping');

        //Check for the existence of the table
        if ($setup->getConnection()->isTableExists($tableName) == true) {

            $data = [];

            $filename ='/app/code/Clmw/AccountManager/Files/account_manager_mapping.csv';
            $datafile = $filepath.$filename;

            $rows   = array_map('str_getcsv', file($datafile));
            $header = array_shift($rows);
            $data    = array();
            foreach($rows as $row) {
                $data[] = array_combine($header, $row);
            }

            foreach ($data as $item) {
                $setup->getConnection()->insert($tableName, $item);
            }
        }


        $setup->endSetup();
    }
}
