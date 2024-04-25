<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Logs;

use Exception;
use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\Log;
use GlsPoland\Shipping\Model\ResourceModel\Log\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Message\ManagerInterface;
use Magento\Ui\Component\MassAction\Filter;

class Delete extends Action
{
    /** @var Log */
    protected Log $log;

    /** @var ManagerInterface */
    protected $messageManager;

    /** @var CollectionFactory */
    protected CollectionFactory $collectionLog;

    /** @var Config */
    private Config $config;

    /** @var Filter */
    protected Filter $filter;

    /**
     * Constructor
     *
     * @param Log $log
     * @param ManagerInterface $messageManager
     * @param Context $context
     * @param CollectionFactory $collectionLog
     * @param Config $config
     * @param Filter $filter
     */
    public function __construct(
        Log $log,
        ManagerInterface $messageManager,
        Context $context,
        CollectionFactory $collectionLog,
        Config $config,
        Filter $filter
    ) {
        $this->log = $log;
        $this->messageManager = $messageManager;
        $this->collectionLog = $collectionLog;
        $this->config = $config;
        $this->filter = $filter;

        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            $deleted = 0;
            $collection = $this->filter->getCollection($this->collectionLog->create());

            foreach ($collection as $item) {
                $item->delete();
                $deleted++;
            }

            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $deleted));

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_INFO,
                    'GLS module',
                    sprintf(
                        '[%s] %s',
                        __METHOD__,
                        __('A total of %1 record(s) have been deleted.', $deleted)
                    )
                );
            }
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong on delete logs.')
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS module',
                    sprintf(
                        '[%s] %s %s',
                        __METHOD__,
                        __('Something went wrong on delete logs.'),
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
