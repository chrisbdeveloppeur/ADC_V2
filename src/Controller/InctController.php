<?php

namespace App\Controller;

use App\Form\FromInctFormType;
use App\Form\TypeInterInctForm;
use App\Form\TypeInterTasktForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/INC", name="inct_")
 */
class InctController extends AbstractController
{
    /**
     * @Route("/type", name="home")
     */
    public function typeInct(Request $request, CheminController $cheminController)
    {
        $survey = $this->get('session')->get('survey');
        $survey->setCasInct(null);
        $type = $survey->getType();
        if ($type == "INC") {
            $form = $this->createForm(TypeInterInctForm::class);
        } elseif ($type == 'DEM') {
            $form = $this->createForm(TypeInterTasktForm::class);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $reponse = $form->get('type')->getData();
            $survey->setCasInct($reponse);
            $cas = $survey->getService().'_'.$survey->getType().'_'.$reponse;
            $survey->setCas($cas);
//            dd($survey);
            $survey->setTypeInter($reponse);
            if ($reponse == '1') {         /* Changement de PC */
                return $this->redirectToRoute('form_asset');
            } elseif ($reponse == '2') {   /* Autre intervention matérielle */
                return $this->redirectToRoute('form_other_asset');
            } elseif ($reponse == '3') {                      /* Intervention software */
                return $this->redirectToRoute('form_app');
            }
        }

        $referer = $request->headers->get('referer');
        $cheminController->setChemins($request);
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
            'referer' => $referer,
        ]);

    }



}
