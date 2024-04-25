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

class Clear extends Action
{
    /** @var Log */
    protected Log $log;

    /** @var ManagerInterface */
    protected $messageManager;

    /** @var CollectionFactory */
    protected CollectionFactory $collectionLog;

    /** @var Config */
    private Config $config;

    /**
     * Constructor
     *
     * @param Log $log
     * @param ManagerInterface $messageManager
     * @param Context $context
     * @param CollectionFactory $collectionLog
     * @param Config $config
     */
    public function __construct(
        Log $log,
        ManagerInterface $messageManager,
        Context $context,
        CollectionFactory $collectionLog,
        Config $config
    ) {
        $this->log = $log;
        $this->messageManager = $messageManager;
        $this->collectionLog = $collectionLog;
        $this->config = $config;

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
            $collection = $this->collectionLog->create();
            $collection->clearLog();
            $this->messageManager->addSuccessMessage(__('All logs have been deleted.'));

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_INFO,
                    'GLS module',
                    sprintf(
                        '[%s] %s',
                        __METHOD__,
                        __('All logs have been deleted.')
                    )
                );
            }
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong on delete all logs.')
            );

            if ($this->config->isDebugEnabled()) {
                $this->log->add(
                    $this->log::LOG_TYPE_ERROR,
                    'GLS module',
                    sprintf(
                        '[%s] %s %s',
                        __METHOD__,
                        __('Something went wrong on delete all logs.'),
                        $e->getMessage()
                    )
                );
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
