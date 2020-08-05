<?php

namespace SM\SU\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;

class Router implements \Magento\Framework\App\RouterInterface
{
    const BLOG_ROUTER = 'blogs';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \SM\SU\Model\ResourceModel\Blog\CollectionFactory
     */
    private $postCollectionFactory;
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    private $actionFactory;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        ScopeConfigInterface $scopeConfig,
        \SM\SU\Model\ResourceModel\Blog\CollectionFactory $postCollectionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->actionFactory = $actionFactory;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $suffix = $this->scopeConfig->getValue('managepost/general/suffix');
        $identifier = trim($request->getPathInfo(), '/');
        $requestPath = str_replace($suffix, '', $identifier);
        $requestParts = explode('/', $requestPath);

        if (count($requestParts) > 0 && $requestParts[0] != self::BLOG_ROUTER) {
            return null;
        }

        if (count($requestParts) == 1) {
            $request->setModuleName('sumup')->setControllerName('index')->setActionName('bloglist');
        } else {
            /* @var \SM\SU\Model\Blog $post */
            $postCollection = $this->postCollectionFactory->create();
            $postCollection->addFieldToFilter('url_key', $requestParts[1]);
            if (!$postCollection->getSize()) {
                return null;
            }

            $post = $postCollection->getFirstItem();
            $request->setModuleName('sumup')
            ->setControllerName('index')
            ->setActionName('blogdetail')->setParam('blog_id', $post->getId());
        }

        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);
        return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class,['request' => $request]);
    }
}
