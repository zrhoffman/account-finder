<?php


namespace App\Normalizer;


use App\Entity\Contact;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class ContactNormalizer extends GetSetMethodNormalizer
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Contact &&
            parent::supportsNormalization($data, $format);
    }

    /*
     * getAttributes() is only used for normalization, not denormalization.
     */
    protected function getAttributes($object, $format = null, array $context)
    {
        return Contact::$exposedAttributes;
    }
}