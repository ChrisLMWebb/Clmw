<?php

namespace Clmw\AccountManager\Model\ResourceModel\SetSalesManager;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Clmw\AccountManager\Model\SetSalesManager',
            'Clmw\AccountManager\Model\ResourceModel\SetSalesManager'
        );
    }
}
