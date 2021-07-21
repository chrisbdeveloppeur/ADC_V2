<?php

namespace App\Controller;

use App\Form\TypeInterTasktForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*
 * TasktController.php contient la logique pour le cheminement qui suit la selection de la branche demande (type = DEM)
*/

/**
 * @Route("/DEM", name="taskt_")
 */
class TasktController extends AbstractController
{

    /**
     * @Route("/type", name="home")
     */
    public function fromInct(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController): Response
    {

        $survey = $surveySessionController->checkSurveySession();
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

        $survey->setCasInct(null);
        $type = $survey->getType();
        $form = $this->createForm(TypeInterTasktForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $reponse = $form->get('type')->getData();
            $survey->setCasTaskt($reponse);
            $cas = $survey->getService() . '_' . $type . '_' . $reponse;
            $survey->setCas($cas);
            $survey->setTypeInter($reponse);
            if ($reponse == '1') {         /* Fourniture, reprise et déménagement de postes de travail */
                return $this->redirectToRoute('asset');
            } elseif ($reponse == '2') {   /* Fourtinure, reprise et déménagement de matériels hors postes de travail */
                return $this->redirectToRoute('other_asset');
            } elseif ($reponse == '3') {                      /* Installaition d'applications sans fourniture de matériel */
                return $this->redirectToRoute('app');
            } elseif ($reponse == '4') {                      /* Autre actions matériel */
                return $this->redirectToRoute('other_action');
            } elseif ($reponse == '5') {                      /* Autre actions logiciel accès */
                return $this->redirectToRoute('other_app');
            } elseif ($reponse == '6') {                      /* Support téléphonie */
                return $this->redirectToRoute('phone');
            } elseif ($reponse == '7') {                      /* CMDB et stock */
                return $this->redirectToRoute('cmdb');
            }
        }

        $cheminController->setChemins($request);

        return $this->render('Survey/home/type_inter.html.twig', [
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }
}

