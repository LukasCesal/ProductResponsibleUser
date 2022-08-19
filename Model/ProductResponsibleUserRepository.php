<?php
declare(strict_types=1);

namespace Aiti\ProductResponsibleUser\Model;

use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterface as UserInterface;
use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterfaceFactory as UserInterfaceFactory;
/*use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserSearchResultsInterfaceFactory;*/
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Aiti\ProductResponsibleUser\Model\ResourceModel\ProductResponsibleUser as ResourceUser;
use Aiti\ProductResponsibleUser\Model\ResourceModel\ProductResponsibleUser\CollectionFactory as UserCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterfaceSearchResults;
use Aiti\ProductResponsibleUserApi\Api\Data\ProductResponsibleUserInterfaceSearchResultsFactory;

class ProductResponsibleUserRepository implements ProductResponsibleUserRepositoryInterface
{

    /**
     * @var ResourceUser
     */
    protected $resource;

    /**
     * @var UserInterfaceFactory
     */
    protected $userFactory;

    /**
     * @var UserCollectionFactory
     */
    protected $userCollectionFactory;

    /**
     * @var ProductResponsibleUserInterfaceSearchResultsFactory
     */
    protected ProductResponsibleUserInterfaceSearchResultsFactory $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;


    /**
     * @param ResourceUser $resource
     * @param UserInterfaceFactory $userFactory
     * @param UserCollectionFactory $userCollectionFactory
     * @param ProductResponsibleUserInterfaceSearchResultsFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceUser $resource,
        UserInterfaceFactory $userFactory,
        UserCollectionFactory $userCollectionFactory,
        ProductResponsibleUserInterfaceSearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->userFactory = $userFactory;
        $this->userCollectionFactory = $userCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(UserInterface $user)
    {
        try {
            $this->resource->save($user);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the User: %1',
                $exception->getMessage()
            ));
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function get($userId)
    {
        $user = $this->userFactory->create();
        $this->resource->load($user, $userId);
        if (!$user->getId()) {
            throw new NoSuchEntityException(__('User with id "%1" does not exist.', $userId));
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->userCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(UserInterface $user)
    {
        try {
            $userModel = $this->userFactory->create();
            $this->resource->load($userModel, $user->getUserId());
            $this->resource->delete($userModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the User: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($userId)
    {
        return $this->delete($this->get($userId));
    }
}

