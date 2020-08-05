<?php
//namespace SM\SU\Plugin;
//
//class Topmenu
//{
//    public function __construct(
//        \Magento\Customer\Model\Session $session
//    ) {
//        $this->Session = $session;
//    }
//
//    public function afterGetHtml(\Magento\Theme\Block\Html\Topmenu $topmenu, $html)
//    {
//        $swappartyUrl = $topmenu->getUrl('blogs');//here you can set link
//        $magentoCurrentUrl = $topmenu->getUrl('sumup/index/bloglist', ['_current' => true, '_use_rewrite' => true]);
//        if (strpos($magentoCurrentUrl, 'sumup/custommenu') !== false) {
//            $html .= "<li class=\"level0 nav-5 active level-top parent ui-menu-item\">";
//        } else {
//            $html .= "<li class=\"level0 nav-4 level-top parent ui-menu-item\">";
//        }
//        $html .= "<a href=\"" . $swappartyUrl . "\" class=\"level-top ui-corner-all\"><span>" . __("Blogs") . "</span></a>";
//        $html .= "</li>";
//        return $html;
//    }
//}


namespace SM\SU\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;
use SM\SU\Api\Data\CategoryInterface;
use SM\SU\Model\ResourceModel\Category\CollectionFactory as CategoryCollection;

class TopMenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    protected $categoryCollection;

    /**
     * @param CategoryCollection $categoryCollection
     * @param NodeFactory $nodeFactory
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        CategoryCollection $categoryCollection,
        NodeFactory $nodeFactory,
        UrlInterface $urlBuilder
    )
    {
        $this->categoryCollection = $categoryCollection;
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject
    )
    {
        $categories = $this->loadCategories();
        /**
         * Parent Menu
         */
        $menuNode = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray("Blogs", "blogs"),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree(),
            ]
        );

        /**
         * Add Child Menu
         */
        foreach ($categories as $category) {
            $menuNode->addChild(
                $this->nodeFactory->create(
                    [
                        'data' => $this->getNodeAsArray($category['category_name'], $this->urlBuilder->getUrl('blogs', ['id' => $category['category_id']])),
                        'idField' => 'id',
                        'tree' => $subject->getMenu()->getTree(),
                    ]
                )
            );
            $subject->getMenu()->addChild($menuNode);
        }
    }

    public function loadCategories()
    {
        return $collection = $this->categoryCollection->create()->addFieldToFilter(CategoryInterface::PARENT_ID, ['neq' => '0']);
    }

    protected function getNodeAsArray($name, $id)
    {
        $url = $this->urlBuilder->getUrl($id);
        return [
            'name' => __($name),
            'id' => $id,
            'url' => $url,
            'has_active' => false,
            'is_active' => false,
        ];
    }
}
