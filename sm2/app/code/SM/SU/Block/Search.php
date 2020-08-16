<?php

namespace SM\SU\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use SM\SU\Helper\Data;
use Magento\Backend\Block\Widget\Context;
use SM\SU\Model\ResourceModel\Brand\CollectionFactory;


/**
 * Class Search
 * @package SM\SU\Block
 */
class Search extends Template
{
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $collectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context, $data);

    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getSearchBlogData()
    {
        //die('dit cu m');
        $result = [];
        $brand = $this->collectionFactory->create();

        if (!empty($brand)) {
            foreach ($brand as $item) {
                $result[] = [
                    'value' => $item->getName(),
                    'url'   => $item->getUrl(),
                    'image' => $item->getImage(),
                    'desc'  => "12312",
                ];
            }
        }
        return $this->encodeSomething($result);
    }
    public function encodeSomething(array $dataToEncode)
    {
        $encodedData = $this->jsonHelper->jsonEncode($dataToEncode);

        return $encodedData;
        var_dump();
    }
}
