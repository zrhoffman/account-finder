<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\PhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findPrimaryContactsByAccount(Account $account): array
    {
        $contactsDQL = $this->createQueryBuilder('contact')
            ->where('contact.account = :accountValue')
            ->setParameter('accountValue', $account)
            ->andWhere('contact.accountOwner = :ownerValue')
            ->setParameter('ownerValue', true)
            ->getDQL();

        $queryParameters = [
            'accountValue' => $account,
            'ownerValue' => true,
        ];

        /* @var PhoneNumberRepository $phoneNumberRepository */
        $phoneNumberRepository = $this->_em->getRepository(PhoneNumber::class);
        $phoneNumbers = $phoneNumberRepository->findPrimaryPhoneNumbersByContacts($contactsDQL, $queryParameters);

        $contacts = [];

        /* @var PhoneNumber $phoneNumber */
        foreach ($phoneNumbers as $phoneNumber) {
            $contacts[] = $phoneNumber->getContact();
        }

        return $contacts;
    }
}
