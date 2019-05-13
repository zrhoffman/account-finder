<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\PhoneNumber;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends EntityRepository
{
    public function findPrimaryContactsByAccount(Account $account): QueryBuilder
    {
        $entityManager = $this->getEntityManager();
        $expression = $entityManager->getExpressionBuilder();

        $query = $this->createQueryBuilder('contact')
            ->where('contact.account = :accountValue')
            ->setParameter('accountValue', $account)
            ->andWhere(
                $expression->in(
                    ':primaryValue',
                    $entityManager->createQueryBuilder()
                        ->select('phoneNumber.primaryPhoneNumber')
                        ->from(PhoneNumber::class, 'phoneNumber')
                        ->getDQL()
                )
            )
            ->setParameter('primaryValue', true);

        return $query;
    }
}
