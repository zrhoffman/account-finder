<?php

namespace App\Repository;

use App\Entity\PhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PhoneNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneNumber[]    findAll()
 * @method PhoneNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneNumberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhoneNumber::class);
    }

    public function findPrimaryPhoneNumbersByContacts(string $contactsDQL, array $queryParameters) : array
    {
        $expression = $this->getEntityManager()->getExpressionBuilder();

        $query = $this->createQueryBuilder('phoneNumber')

            ->where(
                $expression->in(
                    'phoneNumber.contact',
                    $contactsDQL
                )
            )
            ->andWhere('phoneNumber.primaryPhoneNumber = :primaryValue')
            ->setParameter('primaryValue', true);

        foreach ($queryParameters as $parameter => $value) {
           $query->setParameter($parameter, $value);
        }

        $phoneNumbers = $query->getQuery()
            ->execute();

        return $phoneNumbers;
    }
}
