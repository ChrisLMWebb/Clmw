<?php
namespace Clmw\AccountManager\Model\ResourceModel\Order\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderGridCollection;
use Psr\Log\LoggerInterface as Logger;

class Collection extends OrderGridCollection

{

    public function __construct(

        EntityFactory $entityFactory,

        Logger $logger,

        FetchStrategy $fetchStrategy,

        EventManager $eventManager,

                      $mainTable = 'sales_order_grid',

                      $resourceModel = Order::class

    ) {

        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);

    }

    protected function _renderFiltersBefore() {

        $joinTable = $this->getTable('sales_manager_mapping');

        $this->getSelect()->joinLeft(

            ['sales_manager_mapping' => $joinTable],

            'main_table.entity_id = sales_manager_mapping.order_id',

            ['manager_name']

        );

        parent::_renderFiltersBefore();

    }

}
