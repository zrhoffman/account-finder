<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends ApiController
{
    /**
     * @Get(
     *     "/accounts/{status<all|active|inactive>}.{_format}",
     *     defaults={"_format"="json", "status"="active"},
     *     )
     * @param Request $request
     * @param string $status
     * @return Response
     */
    public function list(Request $request, string $status)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /* @var AccountRepository $accountRepository */
        $accountRepository = $entityManager->getRepository(Account::class);
        $query = $accountRepository->findByStatus($status);

        $accounts = $query
            ->getQuery()
            ->execute();

        return $this->handleView(
            $this->view(
                $accounts
            )
        );
    }
}
