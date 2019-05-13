<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountContactController extends ApiController
{
    /**
     * @Get(
     *     "/accounts/{account}/contacts/primary.{_format}", defaults={"_format"="json"}, requirements={"accountId"="\d+"},
     *     condition="request.get('direction', 'desc') in ['desc', 'asc']",
     *     )
     * @param Request $request
     * @param Account $account
     * @return Response
     */
    public function primaryContact(Request $request, Account $account)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sortDirection = $request->get('direction', 'desc');
        $sortColumn = $request->get('sort', 'id');
        $columnNames = $entityManager->getClassMetadata(Contact::class)->getFieldNames();
        if (array_search($sortColumn, $columnNames, true) === false) {
            throw $this->createNotFoundException('Invalid sort column.');
        }

        /* @var ContactRepository $contactRepository */
        $contactRepository = $entityManager->getRepository(Contact::class);
        $contacts = $contactRepository->findPrimaryContactsByAccount($account)
            ->orderBy('contact.' . $sortColumn, $sortDirection)
            ->getQuery()
            ->execute();

        return $this->handleView(
            $this->view(
                $contacts
            )
        );
    }
}
