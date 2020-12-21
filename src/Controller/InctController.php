<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InctController extends AbstractController
{
    /**
     * @Route("/inct", name="inct")
     */
    public function index(): Response
    {
        return $this->render('inct/index.html.twig', [
            'controller_name' => 'InctController',
        ]);
    }
}
