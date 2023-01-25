<?php

namespace Nini\Linkedin\Model\Customer\Attribute;

use Nini\Linkedin\Setup\Patch\Data\LinkedinCreatePatch;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class LinkedinBackend extends AbstractBackend
{
    /**
     * @param $object
     * @return LinkedinBackend|\Magento\Framework\DataObject
     * @throws LocalizedException
     */
    public function beforeSave($object)
    {
        $objLink = $object->getData(LinkedinCreatePatch::Linkedin_Customer);

        if (!$this->validatelinkedin($objLink)) {
            throw new LocalizedException(
                __('Provided linkedin profile url is wrong')
            );
        }

        $this->validate($object);

        return $object;
    }

    private function validatelinkedin(string $profileUrl): bool
    {
        $pattern = '/^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)/m';

        return preg_match($pattern, $profileUrl);
    }
}