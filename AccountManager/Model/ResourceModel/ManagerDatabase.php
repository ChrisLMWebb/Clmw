<?php

namespace Clmw\AccountManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ManagerDatabase extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('account_manager_mapping', 'manager_id');
    }
}
