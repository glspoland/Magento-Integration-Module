<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\UrlInterface;

class Index extends Action
{
    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /** @var UrlInterface */
    private UrlInterface $urlBuilder;

    /**
     * Class constructor.
     *
     * @param Context $context
     * @param RedirectFactory $resultRedirectFactory
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Context $context,
        RedirectFactory $resultRedirectFactory,
        UrlInterface $urlBuilder
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $configUrl = $this->urlBuilder->getUrl(
            'adminhtml/system_config/edit',
            [
                'section' => 'carriers',
                '_fragment' => 'carriers_glspolandgroup-link',
            ]
        );

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl($configUrl);
        $resultRedirect->setUrl($url);

        return $resultRedirect;
    }
}
