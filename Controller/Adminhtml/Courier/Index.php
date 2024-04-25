<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Courier;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'GlsPoland_Shipping::gls_courier';

    /** @var PageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * Class constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * @return Page
     */
    public function execute(): Page
    {
        $message = 'Attention! Only one order can be placed within one company for the given pickup date. '
            . 'Parcels may be collected on the next business day at the earliest!';
        $this->messageManager->addNoticeMessage(__($message));

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('GlsPoland_Shipping::gls_courier');
        $resultPage->getConfig()->getTitle()->prepend(__('Order GLS Courier'));

        return $resultPage;
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('GlsPoland_Shipping::gls_courier');
    }
}
