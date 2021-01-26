<?php

namespace App\Controller;

use App\Form\FromInctFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/inct", name="inct_")
 */
class InctController extends AbstractController
{
    /**
     * @Route("/from-inct", name="")
     */
    public function fromInct(Request $request, EntityManagerInterface $em): Response
    {
        $survey = $this->getUser()->getSurvey();
        $form = $this->createForm(FromInctFormType::class);
        $form->handleRequest($request);
        $from_inct = $form->get('from_inct')->getData();
        if ($form->isSubmitted() && $form->isValid()){
            if ($from_inct == 'Non'){
                $survey->setFromInct('Non');
            }else{
                $survey->setFromInct('Oui');
            }
            $em->persist($survey);
            $em->flush();
            return $this->redirectToRoute("taskt_asset_type",  [
            ]);
        }
        return $this->render('Survey/Taskt/from_inct_field.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
