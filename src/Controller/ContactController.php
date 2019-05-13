<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends ApiController
{
    /**
     * @Get("/accounts/{account}/contacts/primary.{_format}", defaults={"_format"="json"}, requirements={"accountId"="\d+"})
     * @param Account $account
     * @return Response
     */
    public function primaryContact(Account $account)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /* @var ContactRepository $contactRepository */
        $contactRepository = $entityManager->getRepository(Contact::class);
        $contacts = $contactRepository->findPrimaryContactsByAccount($account);

        return $this->handleView(
            $this->view(
                $contacts
            )
        );
    }
}
