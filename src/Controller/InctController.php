<?php

namespace App\Controller;

use App\Form\TypeInterInctForm;
use App\Form\TypeInterTasktForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * InctController.php contient la logique pour le cheminement qui suit la selection de la branche incident (type = INC)
*/

/**
 * @Route("/INC", name="inct_")
 */
class InctController extends AbstractController
{
    /**
     * @Route("/type", name="home")
     */
    public function typeInct(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController)
    {
        $survey =  $surveySessionController->checkSurveySession();
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

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
                return $this->redirectToRoute('asset');
            } elseif ($reponse == '2') {   /* Autre intervention matérielle */
                return $this->redirectToRoute('other_asset');
            } elseif ($reponse == '3') {                      /* Intervention software */
                return $this->redirectToRoute('app');
            }
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);

    }



}
