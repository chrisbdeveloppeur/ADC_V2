<?php

namespace App\Controller;

use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinalStringController extends AbstractController
{
    /**
     * @Route("/final-string", name="final_string")
     */
    public function description(Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $finalStringForm = $this->createForm(FinalStringFormType::class);
        $finalStringForm->handleRequest($request);

        return $this->render('Survey/forms/final_string_form.html.twig',[
//            'form' => $form->createView(),
            'final_string_form' => $finalStringForm->createView(),
        ]);
    }
}
