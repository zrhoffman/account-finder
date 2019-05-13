<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends ApiController
{
    /**
     * @Get("/accounts/active.{_format}", defaults={"_format"="json"})
     * @return Response
     */
    public function active()
    {
        $entityManager = $this->getDoctrine()->getManager();

        /* @var AccountRepository $accountRepository */
        $accountRepository = $entityManager->getRepository(Account::class);
        $accounts = $accountRepository->findByActive(true);

        return $this->handleView(
            $this->view(
                $accounts
            )
        );
    }
}
