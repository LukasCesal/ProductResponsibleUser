<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUser\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductResponsibleUser extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('aiti_productresponsibleuser_user', 'user_id');
    }
}

