<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\PhoneNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AppFixtures extends Fixture
{
    /*
     * @var Serializer $serializer
     */
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager /* @var EntityManager $manager */ $manager)
    {
        $normalizers = [
            new GetSetMethodNormalizer()
        ];

        $serializer = new Serializer(
            $normalizers,
            [
                new JsonEncoder()
            ]
        );

        /**
         * todo: derive project root from $manager
         */
        $seedData = json_decode(
            file_get_contents(
                __DIR__ . '/../../assets/SeedData.json',
                true
            ),
            true
        );

        foreach ($seedData['accounts'] as $accountSeed) {
            $account = $serializer->deserialize(
                json_encode($accountSeed),
                Account::class,
                'json'
            );
            $manager->persist($account);

            foreach ($accountSeed['contacts'] as $contactSeed) {
                /* @var Contact $contact */
                $contact = $serializer->deserialize(
                    json_encode($contactSeed),
                    Contact::class,
                    'json'
                );

                $contact->setAccount($account);
                $manager->persist($contact);

                foreach ($contactSeed['phoneNumbers'] as $phoneNumberSeed) {
                    /* @var PhoneNumber $phoneNumber */
                    $phoneNumber = $serializer->deserialize(
                        json_encode($phoneNumberSeed),
                        PhoneNumber::class,
                        'json'
                    );

                    $phoneNumber->setContact($contact);
                    $manager->persist($phoneNumber);
                }
            }
        }

        $manager->flush();
    }
}
