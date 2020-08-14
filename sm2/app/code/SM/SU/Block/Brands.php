<?php

namespace SM\SU\Block;
use Magento\Customer\Model\Context as CustomerContext;

class Brands extends \Magento\Framework\View\Element\Template
{
    /**
     * Group Collection
     */
    protected $_brandCollection;

    protected $_collection = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $_brandHelper;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    protected $_catalogProductVisibility;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry                      $registry
     * @param \SM\SU\Helper\Data                           $brandHelper
     * @param \SM\SU\Model\Brand                           $brandCollection
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \SM\SU\Helper\Data $brandHelper,
        \SM\SU\Model\Brand $brandCollection,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,

        array $data = []
    ) {
        $this->_brandCollection = $brandCollection;
        $this->_brandHelper = $brandHelper;
        $this->_coreRegistry = $registry;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

//    public function _construct(){
//        if(!$this->getConfig('general_settings/enable') || !$this->getConfig('brand_block/enable')) return;
//        parent::_construct();
//        $carousel_layout = $this->getConfig('brand_block/carousel_layout');
//        $template = '';
//        if($carousel_layout == 'owl_carousel'){
//            $template = 'block/brand_list_owl.phtml';
//        }else{
//            $template = 'block/brand_list_bootstrap.phtml';
//        }
//        if(!$this->getTemplate() && $template!=''){
//            $this->setTemplate($template);
//        }
//    }

    public function getConfig($key, $default = '')
    {
        $widget_key = explode('/', $key);
        if( (count($widget_key)==2) && ($resultData = $this->hasData($widget_key[1])) )
        {
            return $this->getData($widget_key[1]);
        }
        $result = $this->_brandHelper->getConfig($key);
        if($result == ""){
            return $default;
        }
        return $result;
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Brand List'));
        //if ($this->getCustomCollection()) {
        $pager = $this->getLayout()->createBlock(
            'Magento\Theme\Block\Html\Pager',
            'custom.history.pager'
        )->setAvailableLimit([ 5 => 5, 10 => 10, 15 => 15, 20 => 20])
            ->setShowPerPage(true)->setCollection(
                $this->getBrandCollection()
            );
        $this->setChild('pager', $pager);
//         $this->getCustomCollection()->load();
//         }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getBrandCollection()
    {
        if(!$this->_collection) {
            $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
            $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
            $collection = $this->_brandCollection->getCollection()
                ->setOrder('name','ASC')
                ->addFieldToFilter('status',1);
            $searchblog = ($this->getRequest()->getParam('q')) ? $this->getRequest()->getParam('q') : "";
            if (!empty($searchblog)) {
                $collection->addFieldToFilter('name', ['like' => '%' . $searchblog . '%']);
            }
            $searchBrandByChar = ($this->getRequest()->getParam('char')) ? $this->getRequest()->getParam('char') : "";
            if (!empty($searchBrandByChar) && $searchBrandByChar != '0-9') {
                $collection->addFieldToFilter('name', ['like' => $searchBrandByChar . '%']);
            }
//            $collection->getSelect()
//                ->columns(new \Zend_Db_Expr('SUBSTR(name, 1, 1) AS first_letter'));
            $collection->setPageSize($pageSize);
            $collection->setCurPage($page);
            $this->_collection = $collection;
        }
        return $this->_collection;
    }


    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return [
            'SM_BRAND_LIST',
            $this->_storeManager->getStore()->getId(),
            $this->_design->getDesignTheme()->getId(),
            $this->httpContext->getValue(CustomerContext::CONTEXT_GROUP),
            'template' => $this->getTemplate(),
            $this->getProductsCount()
        ];
    }

    public function _toHtml()
    {
        return parent::_toHtml();
    }
    public function getProductCount(\SM\SU\Model\Brand $brand)
    {
        $collection = $brand->getProductCollection();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        return count($collection);
    }
}
