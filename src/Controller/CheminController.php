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
//        if (end($array) != $referer){
//            array_pop($array);
//            $survey->setChemin($array);
//        }
        foreach ($array as $key => $value){
            dump($key .'=>'. $value);
            if ($value != $referer){
                $newArray[] = $value;
            }elseif ($value == $referer){
                $newArray[] = $value;
                break;
            }
        }
        $survey->setChemin($newArray);
        dump($survey);
    }

}