<?php
//
//namespace SM\SU\Model;
//
//use Magento\Catalog\Model\ResourceModel\Product\Collection;
//use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
//use Magento\Framework\Api\AttributeValueFactory;
//use Magento\Framework\Api\ExtensionAttributesFactory;
//use Magento\Framework\App\ObjectManager;
//use Magento\Framework\DataObject\IdentityInterface;
//use Magento\Framework\Image as MagentoImage;
//use Magento\Framework\Image\Factory as ImageFactory;
//use Magento\Framework\Model\AbstractExtensibleModel;
//use Magento\Framework\Model\AbstractModel;
//use Magento\Framework\Model\Context;
//use Magento\Framework\Registry;
//use Magento\Store\Model\StoreManagerInterface;
//use SM\SU\Api\Data\CategoryInterface;
//use SM\SU\Api\Data\BlogInterface;
////use SM\SU\Api\Data\TagInterface;
////use Mirasvit\Blog\Api\Repository\AuthorRepositoryInterface;
//use SM\SU\Api\CategoryRepositoryInterface;
////use Mirasvit\Blog\Api\Repository\TagRepositoryInterface;
//
//class Blog extends AbstractModel implements IdentityInterface
//{
//    const ENTITY    = 'blog_post';
//    const CACHE_TAG = 'blog_post';
//
//    /**
//     * @var MagentoImage
//     */
//    protected $_processor;
//
//    /**
//     * @var Url
//     */
//    protected $url;
//
//    /**
//     * @var StoreManagerInterface
//     */
//    protected $storeManager;
//
//    /**
//     * @var Config
//     */
//    protected $config;
//
//    protected $productCollectionFactory;
//
//    /**
//     * @var CategoryRepositoryInterface
//     */
//    private $categoryRepository;
//
//    /**
//     * @var TagRepositoryInterface
//     */
//    private $tagRepository;
//
//    /**
//     * @var AuthorRepositoryInterface
//     */
//    private $authorRepository;
//
//    public function __construct(
////        CategoryRepositoryInterface $categoryRepository,
////        TagRepositoryInterface $tagRepository,
//       // AuthorRepositoryInterface $authorRepository,
//        //ProductCollectionFactory $productCollectionFactory
////        Config $config,
////        Url $url,
////        StoreManagerInterface $storeManager,
////        ImageFactory $imageFactory,
////        Context $context,
////        Registry $registry,
////        ExtensionAttributesFactory $extensionFactory,
////        AttributeValueFactory $customAttributeFactory
//    ) {
////        $this->categoryRepository       = $categoryRepository;
////        $this->tagRepository            = $tagRepository;
//       // $this->authorRepository         = $authorRepository;
//        //$this->productCollectionFactory = $productCollectionFactory;
////        $this->config                   = $config;
////        $this->url                      = $url;
////        $this->storeManager             = $storeManager;
////        $this->imageFactory             = $imageFactory;
//
//        parent::__construct();
//    }
//
//
//
//    protected function _construct()
//    {
//        $this->_init('SM\SU\Model\ResourceModel\Blog');
//    }
//    /**
//     * {@inheritdoc}
//     */
//    public function getIdentities()
//    {
//        return [self::CACHE_TAG . '_' . $this->getId()];
//    }
//
//    public function getDefaultValues()
//    {
//        $values = [];
//
//        return $values;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getStatus()
//    {
//        return $this->getData(self::STATUS);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setStatus($value)
//    {
//        return $this->setData(self::STATUS, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getName()
//    {
//        return $this->getData(self::NAME);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setName($value)
//    {
//        return $this->setData(self::NAME, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getShortDescription()
//    {
//        return $this->getData(self::SHORT_DESCRIPTION);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setShortDescription($value)
//    {
//        return $this->setData(self::SHORT_DESCRIPTION, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getDescription()
//    {
//        return $this->getData(self::DESCRIPTION);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setDescription($value)
//    {
//        return $this->setData(self::DESCRIPTION, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getUrlKey()
//    {
//        return $this->getData(self::URL_KEY);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setUrlKey($value)
//    {
//        return $this->setData(self::URL_KEY, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getThumbnail()
//    {
//        return $this->getData(self::THUMBNAIL);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setThumbnail($value)
//    {
//        return $this->setData(self::THUMBNAIL, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getPublishDateFrom()
//    {
//        return $this->getData(self::PUBLISH_DATE_FROM);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setPublishDateFrom($value)
//    {
//        return $this->setData(self::PUBLISH_DATE_FROM, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getPublishDateTo()
//    {
//        return $this->getData(self::PUBLISH_DATE_TO);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setPublishDateTo($value)
//    {
//        return $this->setData(self::PUBLISH_DATE_TO, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setCategoryIds(array $value)
//    {
//        return $this->setData(self::CATEGORY_IDS, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setTagIds(array $value)
//    {
//        return $this->setData(self::TAG_IDS, $value);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function setProductIds(array $value)
//    {
//        return $this->setData(self::PRODUCT_IDS, $value);
//    }
//
//    /**
//     * @return ResourceModel\Blog\Collection
//     */
//    public function getCategories()
//    {
//        $ids   = $this->getCategoryIds();
//        $ids[] = 0;
//
//        $collection = $this->categoryRepository->getCollection()
//            ->addAttributeToSelect(['*'])
//            ->addFieldToFilter(CategoryInterface::ID, $ids);
//
//        return $collection;
//    }
//    /**
//     * {@inheritdoc}
//     */
//    public function getCategoryIds()
//    {
//        return $this->getData(self::CATEGORY_IDS);
//    }
//
//    /**
//     * @return AbstractDb|AbstractCollection
//     */
//    public function getTags()
//    {
//        $ids   = $this->getTagIds();
//        $ids[] = 0;
//
//        $collection = $this->tagRepository->getCollection()
//            ->addFieldToFilter(TagInterface::ID, $ids);
//
//        return $collection;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getTagIds()
//    {
//        return $this->getData(self::TAG_IDS);
//    }
//
//    /**
//     * @return mixed|Collection
//     */
//    public function getRelatedProducts()
//    {
//        $ids = $this->getProductIds();
//        $url = ObjectManager::getInstance()
//            ->get('Magento\Framework\UrlInterface');
//        if (strpos($url->getCurrentUrl(), 'rest/all/V1/blog') > 0) {
//            return $ids;
//        }
//
//        $ids[] = 0;
//
//        return $this->productCollectionFactory->create()
//            ->addAttributeToSelect('*')
//            ->addFieldToFilter('entity_id', $ids);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getProductIds()
//    {
//        return $this->getData(self::PRODUCT_IDS);
//    }
//
//    /**
//     * @return string
//     * @throws NoSuchEntityException
//     */
//    public function getThumbnailUrl()
//    {
//        return $this->config->getMediaUrl($this->getThumbnail());
//    }
//
////    /**
////     * @param bool $useSid
////     *
////     * @return string
////     */
////    public function getUrl($useSid = true)
////    {
////        return $this->url->getPostUrl($this, $useSid);
////    }
//
//    /**
//     * Prepare category's statuses.
//     *
//     * @return array
//     */
//    public function getAvailableStatuses()
//    {
//        return [self::STATUS_ENABLED => _('Enabled'), self::STATUS_DISABLED => _('Disabled')];
//    }
//}

namespace SM\SU\Model;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use SM\SU\Model\Blog\FileInfo;
use Magento\Framework\DataObject\IdentityInterface;
use SM\SU\Api\Data\CategoryInterface;
use SM\SU\Api\Data\BlogInterface;
use SM\SU\Api\Data\TagInterface;
use SM\SU\Api\TagRepositoryInterface;
use SM\SU\Api\CategoryRepositoryInterface;
class Blog extends \Magento\Framework\Model\AbstractModel implements IdentityInterface,\SM\SU\Api\Data\BlogInterface
{
    const ENTITY    = 'blog_post';
    const CACHE_TAG = 'blog_post';
    protected $_storeManager;

    protected $url;
    protected $config;

    protected $productCollectionFactory;

    private $categoryRepository;


    private $tagRepository;

    public function __construct(
        Config $config,
        Url $url,
        ProductCollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        Context $context,
        Registry $registry,
         CategoryRepositoryInterface $categoryRepository,
         TagRepositoryInterface $tagRepository
    )
    {
        $this->config = $config;
        $this->url = $url;
        $this->tagRepository            = $tagRepository;
        $this->categoryRepository       = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->productCollectionFactory = $productCollectionFactory;

        parent::__construct($context, $registry);
    }

    protected function _construct()
    {
        $this->_init('SM\SU\Model\ResourceModel\Blog');
    }
    public function getIdentities()
{
    return [self::CACHE_TAG . '_' . $this->getId()];
}

    public function getDefaultValues()
{
    $values = [];

    return $values;
}


    /**
     * Get StoreManagerInterface instance
     *
     * @return StoreManagerInterface
     */
    private function _getStoreManager()
    {
        if ($this->_storeManager === null) {
            $this->_storeManager = ObjectManager::getInstance()->get(StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
    /**
    //     * {@inheritdoc}
    //     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function getId() {
        return $this->getData(self::BLOG_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($value)
    {
        return $this->setData(self::STATUS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($value)
    {
        return $this->setData(self::NAME, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setShortDescription($value)
    {
        return $this->setData(self::SHORT_DESCRIPTION, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($value)
    {
        return $this->setData(self::DESCRIPTION, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrlKey($value)
    {
        return $this->setData(self::URL_KEY, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getThumbnail()
    {
        return $this->getData(self::THUMBNAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function setThumbnail($value)
    {
        return $this->setData(self::THUMBNAIL, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishDateFrom()
    {
        return $this->getData(self::PUBLISH_DATE_FROM);
    }

    /**
     * {@inheritdoc}
     */
    public function setPublishDateFrom($value)
    {
        return $this->setData(self::PUBLISH_DATE_FROM, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishDateTo()
    {
        return $this->getData(self::PUBLISH_DATE_TO);
    }

    /**
     * {@inheritdoc}
     */
    public function setPublishDateTo($value)
    {
        return $this->setData(self::PUBLISH_DATE_TO, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryIds(array $value)
    {
        return $this->setData(self::CATEGORY_IDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setTagIds(array $value)
    {
        return $this->setData(self::TAG_IDS, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductIds(array $value)
    {
        return $this->setData(self::PRODUCT_IDS, $value);
    }

    /**
     * @return ResourceModel\Blog\Collection
     */
    public function getCategories()
    {
        $ids   = $this->getCategoryIds();
        $ids[] = 0;

        $collection = $this->categoryRepository->getCollection()
            ->addAttributeToSelect(['*'])
            ->addFieldToFilter(CategoryInterface::ID, $ids);

        return $collection;
    }
    /**
     * {@inheritdoc}
     */
    public function getCategoryIds()
    {
        return $this->getData(self::CATEGORY_IDS);
    }
    /**
     * {@inheritdoc}
     */
    public function getTagIds()
    {
        return $this->getData(self::TAG_IDS);
    }
    /**
     * @return AbstractDb|AbstractCollection
     */
    public function getTags()
    {
        $ids   = $this->getTagIds();

        $ids[] = 0;

        $collection = $this->tagRepository->getCollection()
            ->addFieldToFilter(TagInterface::ID, $ids);


        return $collection;

    }



    /**
     * @return mixed|Collection
     */
    public function getRelatedProducts()
    {
        $ids = $this->getProductIds();
        $url = ObjectManager::getInstance()
            ->get('Magento\Framework\UrlInterface');
        if (strpos($url->getCurrentUrl(), 'rest/all/V1/blog') > 0) {
            return $ids;
        }

        $ids[] = 0;

        return $this->productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('entity_id', $ids);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductIds()
    {
        return $this->getData(self::PRODUCT_IDS);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getThumbnailUrl()
    {
        return $this->config->getMediaUrl($this->getThumbnail());
    }

//    /**
//     * @param bool $useSid
//     *
//     * @return string
//     */
//    public function getUrl($useSid = true)
//    {
//        return $this->url->getPostUrl($this, $useSid);
//    }
    public function getImageUrl()
    {
        $url = '';
        $image = "";
        if ($this->getData('thumbnail_path') != null) {
            $image = $this->getData('thumbnail_path');
        } else {
            $image = 'placeholder.jpg';
        }
        if (!$image) {
            $image = $this->getData('thumbnail');
        }
        if ($image) {
            if (is_string($image)) {
                $url = $this->_getStoreManager()->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . FileInfo::ENTITY_MEDIA_PATH . '/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }


    /**
     * Prepare category's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => _('Enabled'), self::STATUS_DISABLED => _('Disabled')];
    }
    public function getUrl($useSid = true)
    {
        return $this->url->getBlogUrl($this, $useSid);
    }
    public function getTag()
    {
        return $this->getData('tag_names');
    }
    public function getTagNames()
    {
        if (!empty($this->getTag())) {
            $tags = implode(", ", $this->getTag());
            return $tags;
        }
        return " ";
    }

}
