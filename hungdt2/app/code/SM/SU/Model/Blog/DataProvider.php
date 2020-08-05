<?php

namespace SM\SU\Model\Blog;

use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Ui\DataProvider\AbstractDataProvider;
use SM\SU\Api\Data\BlogInterface;
use SM\SU\Api\BlogRepositoryInterface;
use SM\SU\Model\Config;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var BlogRepositoryInterface
     */
    private $postRepository;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        BlogRepositoryInterface $postRepository,
        Config $config,
        Status $status,
        ImageHelper $imageHelper,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->postRepository = $postRepository;
        $this->collection     = $this->postRepository->getCollection();
        $this->config         = $config;
        $this->status         = $status;
        $this->imageHelper    = $imageHelper;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }


    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $result = [];

        foreach ($this->collection as $post) {

            $post = $this->postRepository->get($post->getId());

            $result[$post->getId()] = [
                BlogInterface::BLOG_ID              => $post->getId(),
                BlogInterface::STATUS               => $post->getStatus(),
                BlogInterface::NAME                 => $post->getName(),
                BlogInterface::URL_KEY              => $post->getUrlKey(),
                BlogInterface::PUBLISH_DATE_FROM    => $post->getPublishDateFrom(),
                BlogInterface::PUBLISH_DATE_TO      => $post->getPublishDateTo(),
                BlogInterface::SHORT_DESCRIPTION    => $post->getShortDescription(),
                BlogInterface::DESCRIPTION    => $post->getDescription(),
                BlogInterface::CATEGORY_IDS     => $post->getCategoryIds(),
                BlogInterface::TAG_IDS          => $post->getTagIds(),

                'is_short_content' => $post->getShortContent() ? true : false,
            ];
            if ($post->getThumbnail()) {
                $result[$post->getId()]['thumbnail_path'] = [
                    [
                        'name' => $post->getThumbnail(),
                        'url'  => $this->config->getMediaUrl($post->getThumbnail()),
                        'size' => filesize($this->config->getMediaPath($post->getThumbnail())),
                        'type' => 'image',
                    ],
                ];
            }

            $result[$post->getId()]['links']['products'] = [];
            foreach ($post->getRelatedProducts() as $product) {
                $result[$post->getId()]['links']['products'][] = [
                    'id'        => $product->getId(),
                    'name'      => $product->getName(),
                    'status'    => $this->status->getOptionText($product->getStatus()),
                    'thumbnail' => $this->imageHelper->init($product, 'product_listing_thumbnail')->getUrl(),
                ];
            }
        }
//        var_dump($result);
//        die();

        return $result;
    }
}
