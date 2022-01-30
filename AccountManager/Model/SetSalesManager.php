<?php

namespace Clmw\AccountManager\Model;

use Magento\Framework\Model\AbstractModel;

class SetSalesManager extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Clmw\AccountManager\Model\ResourceModel\SetSalesManager');
    }
}
