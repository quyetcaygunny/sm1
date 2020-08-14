<?php

namespace SM\SU\Observer;

use Magento\Framework\Event\ObserverInterface;

class LoadProductBrand implements ObserverInterface
{
    /**
     * Catalog data
     *
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogData;

    /**
     * @param \Magento\Catalog\Helper\Data $catalogData
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
        )
    {
        $this->_resource = $resource;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('sumup_brand_products');
        if($product->getId()) {
            $productIds = $connection->fetchCol(" SELECT brand_id FROM ".$table_name." WHERE product_id = ".$product->getId());
            $product->setData('product_brand', implode($productIds, ','));
        }

    }
}
