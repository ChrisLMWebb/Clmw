<?php

namespace Clmw\AccountManager\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{

    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Clmw\AccountManager\Helper\Data $helperData

    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {

        echo $this->helperData->getGeneralConfig('enable');
        echo $this->helperData->getGeneralConfig('threshold_value');
        exit();

    }
}
