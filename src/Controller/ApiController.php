<?php


namespace App\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;

class ApiController extends AbstractFOSRestController
{
    protected function view($results = null, $statusCode = null, array $headers = [])
    {
        $data = [
            'results' => $results,
        ];

        if (is_countable($results)) {
            $data['count'] = count($results);
        }


        return parent::view($data, $statusCode, $headers);
    }
}