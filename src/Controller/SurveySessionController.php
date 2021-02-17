<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SurveySessionController extends AbstractController
{

    public function checkSurveySession()
    {
        $survey = $this->get('session')->get('survey');
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
        }else{
            return $survey;
        }
    }

}