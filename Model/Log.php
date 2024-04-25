<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use Exception;
use GlsPoland\Shipping\Config\Config;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;

class Log extends AbstractModel
{
    public const LOG_TYPE_ERROR = 'error';
    public const LOG_TYPE_WARNING = 'warning';
    public const LOG_TYPE_INFO = 'info';

    /** @var ManagerInterface */
    private ManagerInterface $messageManager;

    /** @var Config */
    private Config $config;

    /** @var Json */
    private Json $json;

    /**
     * Log constructor.
     *
     * @param ManagerInterface $messageManager
     * @param Config $config
     * @param Json $json
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        ManagerInterface $messageManager,
        Config $config,
        Json $json,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->config = $config;
        $this->messageManager = $messageManager;
        $this->json = $json;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct(): void
    {
        $this->_init(ResourceModel\Log::class);
    }

    /**
     * Add Log.
     *
     * @param string $type
     * @param string $description
     * @param string $message
     * @return void
     */
    public function add(string $type, string $description, string $message): void
    {
        if (!$this->config->isDebugEnabled()) {
            return;
        }

        try {
            $this->setType(
                $this->limitMessage(
                    $this->serializeMessage($type),
                    50,
                    ''
                )
            );

            $this->setDescription(
                $this->limitMessage(
                    $this->serializeMessage($description),
                    255,
                    ''
                )
            );

            $this->setMessage(
                $this->limitMessage(
                    $this->serializeMessage($message),
                    26370,
                    ' ...'
                )
            );

            $this->save();
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong on add logs.'));
        }
    }

    /**
     * Serialize message.
     *
     * @param mixed $message
     * @return mixed
     */
    private function serializeMessage(mixed $message): mixed
    {
        if (is_array($message) || is_object($message)) {
            $json = $this->json->serialize($message);

            if ($json !== false) {
                return $json;
            }
        }

        return $message;
    }

    /**
     * Limit message.
     *
     * @param string $string
     * @param int $limit
     * @param string $suffix
     * @return string
     */
    private function limitMessage(string $string, int $limit = 16383, string $suffix = ''): string
    {
        if (strlen($string) <= $limit) {
            return $string;
        }

        return substr($string, 0, $limit - strlen($suffix)) . $suffix;
    }
}
