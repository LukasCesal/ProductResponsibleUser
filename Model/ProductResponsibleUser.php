<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUser\Model;

use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterface;
use Magento\Framework\Model\AbstractModel;

class ProductResponsibleUser extends AbstractModel implements ProductResponsibleUserInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Aiti\ProductResponsibleUser\Model\ResourceModel\ProductResponsibleUser::class);
    }

    /**
     * @inheritDoc
     */
    public function getUserId(): ?int
    {
        return $this->getData(self::USER_ID) === null ? null : (int) $this->getData(self::USER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setUserId(?int $userId): ProductResponsibleUser
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * @inheritDoc
     */
    public function getFirstName(): string
    {
        return $this->getData('first_name');
    }

    /**
     * @inheritDoc
     */
    public function setFirstName(string $firstName): ProductResponsibleUser
    {
        $this->setData('first_name', $firstName);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLastName(): string
    {
        return $this->getData('last_name');
    }

    /**
     * @inheritDoc
     */
    public function setLastName(string $lastName): ProductResponsibleUser
    {
        $this->setData('last_name', $lastName);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDepartment(): ?string
    {
        return $this->getData('department');
    }

    /**
     * @inheritDoc
     */
    public function setDepartment(?string $department): ProductResponsibleUser
    {
        $this->setData('department', $department);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData('created_at');
    }
}

