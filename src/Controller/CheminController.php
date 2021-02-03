<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CheminController extends AbstractController
{

    public function setChemins(Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $referer = $request->getRequestUri();
        $response = $survey->searchUrl($referer);
        if (!$response){
            $survey->addUrl($referer);
        }
        $array = $survey->getChemin();

        foreach ($array as $key => $value){
            if ($value != $referer){
                $newArray[] = $value;
            }elseif ($value == $referer){
                $newArray[] = $value;
                break;
            }
        }
        $survey->setChemin($newArray);
    }

}