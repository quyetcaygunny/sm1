<?php

namespace SM\SU\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveProductBrand implements ObserverInterface
{
    /**
     * Catalog data
     *
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogData;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\App\ResourceConnection  $resource
     * @param \Magento\Framework\Registry                         $coreRegistry         [description]
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $coreRegistry
        )
    {
        $this->_resource = $resource;
        $this->_coreRegistry = $coreRegistry;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('sumup_brand_products');
        $productController = $observer->getController();
        $productId = $productController->getRequest()->getParam('id');
        $data = $productController->getRequest()->getPostValue();

        $this->_coreRegistry->register('current_post_product', $data);

        $is_saved_brand = $this->_coreRegistry->registry('fired_save_action');
        if(!$is_saved_brand) {
            if($productId) {
                $connection->query('DELETE FROM ' . $table_name . ' WHERE product_id =  ' . (int)$productId . ' ');
            }
            if(isset($data['product']['product_brand']) && $productId){
                $productBrands = $data['product']['product_brand'];
                if(!is_array($productBrands)){
                    $productBrands = array();
                    $productBrands[] = (int)$data['product']['product_brand'];
                }
                foreach ($productBrands as $k => $v) {
                    if($v) {
                        $connection->query('INSERT INTO ' . $table_name . '(brand_id,product_id,position)'.' VALUES ( ' . $v . ', ' . (int)$productId . ',0)');
                    }
                }
                $this->_coreRegistry->register('fired_save_action', true);
            }
        }
    }
}
