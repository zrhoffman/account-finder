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
     *     condition="request.get('direction', 'desc') in ['desc', 'asc']",
     *     )
     * @param Request $request
     * @param string $status
     * @return Response
     */
    public function list(Request $request, string $status)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sortDirection = $request->get('direction', 'desc');
        $sortColumn = $request->get('sort', 'id');
        $columnNames = $entityManager->getClassMetadata(Account::class)->getFieldNames();
        if (array_search($sortColumn, $columnNames, true) === false) {
            throw $this->createNotFoundException('Invalid sort column.');
        }

        /* @var AccountRepository $accountRepository */
        $accountRepository = $entityManager->getRepository(Account::class);
        $query = $accountRepository->findByStatus($status);

        $accounts = $query->orderBy('account.' . $sortColumn, $sortDirection)
            ->getQuery()
            ->execute();

        return $this->handleView(
            $this->view(
                $accounts
            )
        );
    }
}
