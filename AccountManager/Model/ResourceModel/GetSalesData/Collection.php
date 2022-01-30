<?php

namespace Clmw\AccountManager\Model\ResourceModel\GetSalesData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Clmw\AccountManager\Model\GetSalesData',
            'Clmw\AccountManager\Model\ResourceModel\GetSalesData'
        );
    }
}
