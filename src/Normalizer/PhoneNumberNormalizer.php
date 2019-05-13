<?php


namespace App\Normalizer;


use App\Entity\PhoneNumber;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class PhoneNumberNormalizer extends GetSetMethodNormalizer
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PhoneNumber &&
            parent::supportsNormalization($data, $format);
    }

    /*
     * getAttributes() is only used for normalization, not denormalization.
     */
    protected function getAttributes($object, $format = null, array $context)
    {
        return PhoneNumber::$exposedAttributes;
    }

    public function normalize(/* @var PhoneNumber $phoneNumber */ $phoneNumber, $format = null, array $context = [])
    {
        return $phoneNumber->getPhoneNumber();
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === PhoneNumber::class &&
            parent::supportsDenormalization($data, $type, $format);
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        /* Symfony does not want Entities to have properties named "primary". */
        $data['primaryPhoneNumber'] = $data['primary'];
        unset($data['primary']);

        return parent::denormalize($data, $class, $format, $context);
    }
}