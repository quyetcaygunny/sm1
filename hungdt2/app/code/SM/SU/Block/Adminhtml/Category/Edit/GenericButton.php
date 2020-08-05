<?php
namespace SM\SU\Block\Adminhtml\Category\Edit;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;


class GenericButton
{
    /**
     * @var Context
     */
    private $context;


    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getCategoryId()
    {
        try {
            return
                $this->context->getRequest()->getParam('category_id');
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

