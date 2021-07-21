<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/*
 * CheminController.php contient la logique permettant de récupérer le chemin de résolution établie par l'utilisateur de l'outil.
 * Ce chemin est traité et les différentes données sont récupérer pour les afficher sur les templates twig "nav_breadcrumbs.html.twig" ou encore "nav_indicator.html.twig"
 * */

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