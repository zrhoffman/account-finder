<?php


namespace App\Normalizer;


use App\Entity\Account;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class AccountNormalizer extends GetSetMethodNormalizer
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Account &&
            parent::supportsNormalization($data, $format);
    }

    /*
     * getAttributes() is only used for normalization, not denormalization.
     */
    protected function getAttributes($object, $format = null, array $context)
    {
        return Account::$exposedAttributes;
    }

    public function normalize(/* @var Account $account */ $account, $format = null, array $context = [])
    {
        $accountArray = parent::normalize($account, $format, $context);

        $contactsIndex = array_search('contacts', array_keys($accountArray), true);

        /* We cannot use array_splice() here because we want to add an
         * element with a non-numeric array key.
         */
        $accountArray = array_merge(
            array_slice($accountArray, 0, $contactsIndex),
            [
                'contactsCount' => count($accountArray['contacts']),
            ],
            array_slice($accountArray, $contactsIndex)
        );

        return $accountArray;
    }
}