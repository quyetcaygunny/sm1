<?php

namespace SM\SU\Block\Category;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use SM\SU\Helper\Data as HelperData;
use SM\SU\Model\BrandFactory;
use SM\SU\Model\ResourceModel\Brand\Collection;
use SM\SU\Model\ResourceModel\Brand\CollectionFactory;

/**
 * Class Widget
 * @package SM\Brand\Block\Category
 */
class Menu extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $brandCollection;

    /**
     * @var BrandFactory
     */
    protected $brand;

    /**
     * @var HelperData
     */
    protected $helper;

    /**
     * Menu constructor.
     *
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param CategoryFactory $categoryFactory
     * @param HelperData $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        BrandFactory $brandFactory,
        HelperData $helperData,
        array $data = []
    ) {
        $this->brandCollection = $collectionFactory;
        $this->brand = $brandFactory;
        $this->helper = $helperData;
        parent::__construct($context, $data);
    }

    /**
     * @return Collection
     */
    public function getCollections()
    {
    return $this->brandCollection->
    create()->addFieldToFilter('status', '1')
        ->addFieldToFilter('is_featured', '1')
        ->setOrder('name', 'ASC');

    }

    public function getUrlBrand()
    {
        $brandRoute = $this->helper->getConfig('general_settings/route');

        return $this->getUrl($brandRoute);
    }

    /**
     * @return string
     */
    public function getBrandHomePageTitle()
    {
        return __('Brand');
    }

    /**
     * @return string
     */
}
