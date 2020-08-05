<?php

namespace SM\SU\Ui\Component;

use SM\SU\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
//use Magento\Ui\DataProvider\Modifier\PoolInterface;


/**
 * Class DataProvider
 */
class BlogDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \SM\SU\Model\ResourceModel\Blog\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blogCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blogCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
        //PoolInterface $pool = null
    ) {
        $this->collection = $blogCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        //$this->meta = $this->prepareMeta($this->meta);
    }



}
