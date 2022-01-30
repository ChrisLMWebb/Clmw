<?php

namespace Clmw\AccountManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SetSalesManager extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('sales_manager_mapping', 'entity_id');
    }
}
