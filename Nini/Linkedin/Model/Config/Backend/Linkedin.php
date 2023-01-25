<?php

namespace Nini\Linkedin\Model\Config\Backend;

use Nini\Linkedin\Setup\Patch\Data\LinkedinCreatePatch;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Registry;
use Magento\Framework\Model\Context;
use Nini\Linkedin\Block\LinkedinBlock;
use Magento\Customer\Setup\CustomerSetup;


class Linkedin extends Value
{

    private CustomerSetup $CustomerSetup;

    public function __construct(
        Context $context,
        Registry $registry,
        CustomerSetup $customerSetup,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [])
    {

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->CustomerSetup=$customerSetup;
    }

    public function UpdateRequiment($required ,$attributeCode)
    {
        $returnAttrubute = $this->CustomerSetup->getEavConfig()->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, $attributeCode);
        if ($returnAttrubute->getIsRequired() !== $required)
        {
            $this->CustomerSetup->updateAttribute(
                CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
                $attributeCode,
                'is_required',
                $required
            );

        }
    }


    public function afterSave()
    {
        $value = $this->getValue();
        if ($value === '0' || $value === '1')
        {
            $this->UpdateRequiment(false, LinkedinCreatePatch::Linkedin_Customer);
        } else {
            $this->UpdateRequiment(true, LinkedinCreatePatch::Linkedin_Customer);

        }
        return parent::afterSave();
    }
}