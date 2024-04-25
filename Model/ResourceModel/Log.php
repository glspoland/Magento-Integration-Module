<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use GlsPoland\Shipping\Helper\DateHelper;

class Log extends AbstractDb
{
    /** @var DateHelper */
    protected DateHelper $dateHelper;

    /**
     * Class constructor.
     *
     * @param DateHelper $dateHelper
     * @param Context $context
     */
    public function __construct(DateHelper $dateHelper, Context $context)
    {
        $this->dateHelper = $dateHelper;

        parent::__construct($context);
    }

    /**
     * Init Table.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('gls_logs', 'id');
    }

    /**
     * Before save callback.
     *
     * @param AbstractModel $object
     * @return AbstractDb
     */
    protected function _beforeSave(AbstractModel $object): AbstractDb
    {
        if ($object->isObjectNew()) {
            $currentDate = $this->dateHelper->getDate(null, 'Y-m-d H:i:s', false);
            $object->setData('created_at', $currentDate);
        }

        return parent::_beforeSave($object);
    }
}
