<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUserApi\Model\ResourceModel\User;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'user_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Aiti\ProductResponsibleUser\Model\ProductResponsibleUser::class,
            \Aiti\ProductResponsibleUser\Model\ResourceModel\ProductResponsibleUser::class
        );
    }
}

