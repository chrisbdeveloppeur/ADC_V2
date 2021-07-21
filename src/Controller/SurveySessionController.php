<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SurveySessionController extends AbstractController
{
    /*
     * Controller permettant d'avoir constament l'entité Survey en session, même si celle-ci arrive à expiration (cela evite une erreur)
     * Il est intégré en début de chaque route des formulaires
     *
     * */
    public function checkSurveySession()
    {
        $survey = $this->get('session')->get('survey');
//        dd($survey);
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }else{
            return $survey;
        }
    }

}