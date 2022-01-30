<?php

namespace Clmw\AccountManager\Plugin;

use Clmw\AccountManager\Model\ResourceModel\ManagerDatabase\Collection;
use Clmw\AccountManager\Model\ResourceModel\ManagerDatabase\CollectionFactory;
use Magento\Sales\Api\OrderRepositoryInterface;

class PopulateSalesManagerMapping
{

    /**
     * AddPoNumberToSalesOrder constructor.
     * @param CollectionFactory $clmwSalesOrderCollectionFactory
     */

    protected $clmwSalesOrderCollectionFactory;

    public function __construct(
        CollectionFactory $clmwSalesOrderCollectionFactory
    ) {
        $this->clmwSalesOrderCollectionFactory = $clmwSalesOrderCollectionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param $result
     * @return mixed
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
                                 $result
    ) {
        // We must first grab the record from our custom database table by the order id.

        /** @var Collection $clmwSalesOrder */
        $clmwSalesOrderCollection = $this->clmwSalesOrderCollectionFactory->create();
        $clmwSalesOrder = $clmwSalesOrderCollection
            ->addFieldToFilter('order_id', $result->getId())
            ->getFirstItem();

        // Then, we get the extension attributes that are currently assigned to this order.
        $extensionAttributes = $result->getExtensionAttributes();

        // We then call "setData" on the property we want to set, wtih the value from our custom table.
        $extensionAttributes->setData('id', $clmwSalesOrder->getData('id'));

        // Then, just re-set the extension attributes containing the newly added data...
        $result->setExtensionAttributes($extensionAttributes);

        // ...and finally, return the result.
        return $result;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param $result
     * @return mixed
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
                                 $result
    ) {
        // We do the same thing here, and can save some time by passing the logic to afterGet.
        foreach ($result->getItems() as $order) {
            $this->afterGet($subject, $order);
        }

        return $result;
    }


    //Get threshold Value

    //Get Manager Province Array
    //Get last item of Sales Array
    //Determine if sale meets criteria
    //Write to sales array



}
