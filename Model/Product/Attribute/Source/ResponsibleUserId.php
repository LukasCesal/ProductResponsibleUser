<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Aiti\ProductResponsibleUser\Model\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Aiti\ProductResponsibleUser\Model\ResourceModel\ProductResponsibleUser\CollectionFactory as ProductResponsibleUserCollectionFactory;
use Aiti\ProductResponsibleUserApi\Api\ProductResponsibleUserRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;


/**
 * List of layout updates available for a product.
 */
class ResponsibleUserId extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var \Magento\Framework\App\Cache\Type\Config
     */
    protected $_configCacheType;


    /**
     * ProductResponsibleUserCollection factory
     *
     * @var ProductResponsibleUserCollectionFactory
     */
    protected $_productResponsibleUserCollectionFactory;

    /**
     * ProductResponsibleUserRepositoryInterface factory
     *
     * @var ProductResponsibleUserRepositoryInterface
     */
    protected $_productResponsibleUserRepositoryInterface;

    /**
     * @var Json
     */
    private $_jsonSerializer;

    /**
     * @var SearchCriteriaBuilder
     */
    private $_searchCriteria;

    /**
     * Construct
     *
     * @param ProductResponsibleUserCollectionFactory $productResponsibleUserCollectionFactory
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     */
    public function __construct(
        ProductResponsibleUserCollectionFactory $productResponsibleUserCollectionFactory,
        ProductResponsibleUserRepositoryInterface $productResponsibleUserRepositoryInterface,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Framework\Api\SearchCriteriaBuilder $criteria,
        Json $jsonSerializer
    ) {
        $this->_productResponsibleUserCollectionFactory = $productResponsibleUserCollectionFactory;
        $this->_productResponsibleUserRepositoryInterface = $productResponsibleUserRepositoryInterface;
        $this->_configCacheType = $configCacheType;
        $this->_searchCriteria = $criteria;
        $this->_jsonSerializer = $jsonSerializer ?: ObjectManager::getInstance()->get(Json::class);
    }

    /**
     * Get list of all available countries
     *
     * @return array
     */
    public function getAllOptions()
    {

        $cacheKey = 'PRODUCT_RESPONSIBLE_USER_ID_SELECT';
        if ($cache = $this->_configCacheType->load($cacheKey)) {
            $options = $this->_jsonSerializer->unserialize($cache);
        } else {

            $collection = $this->_productResponsibleUserRepositoryInterface->getList($this->_searchCriteria->create());
            $options = [];
            foreach($collection->getItems() as $item){
                $option = [];
                $option['value'] = $item->getData('user_id');
                $option['label'] = $item->getData('first_name') . ' ' . $item->getData('last_name') . ' (' . $item->getData('department_id') . ')';
                $options[] = $option;
            }
            $this->_configCacheType->save($this->_jsonSerializer->serialize($options), $cacheKey);
        }
        return $options;
    }

}
