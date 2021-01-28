<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinalStringController extends AbstractController
{
    /**
     * @Route("/final-string", name="final_string")
     */
    public function description(Request $request, EntityManagerInterface $em): Response
    {
        $survey = $this->get('session')->get('survey');
        $finalString = '';

        //                  Horodatage
        $finalString .= $survey->getTimeStamp()->format('d/m/Y - H:i');

        //         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $finalString .= " - [" . strtoupper($survey->getHashedString()) . "]\r\n";

        $assets = $survey->getAssets();
        $otherAssets = $survey->getOtherAssets();
        $apps = $survey->getApps();

        $finalString .= $this->miseEnForm2($assets, 'POSTE(S) DE TRAVAIL(S) : ');
        $finalString .= $this->miseEnForm2($otherAssets, 'AUTRE(S) MATERIEL(S) : ');
        $finalString .= $this->miseEnForm2($apps, 'APPLICATION(S) : ');

//        $finalString .= "[ (" . count($apps) . ") INSTALLATION D'APPLICATIONS : ";
//        foreach ($apps as $key => $value){
//            $key++;
//            $app = "[ " . $value->getBalise() . " (".$key.") ] ";
//            $finalString .= $app;
//        }
//        $finalString .= " ]";

//        foreach ($assets as $key => $value){
//            $key++;
//            $assets = "[ " . $value->getBalise() . " (".$key.") ] ";
//            $finalString .= $assets;
//        }
//        foreach ($otherAssets as $key => $value){
//            $key++;
//            $otherAssets = "[ " . $value->getBalise() . " (".$key.") ] ";
//            $finalString .= $otherAssets;
//        }

        if ($survey->getCommentaire()){
            $finalString .= "[COMMENTAIRE_TECHNICIEN_" . $survey->getService() . " : " . $survey->getCommentaire() . "]";
        }
//        $finalString .= "[" . $survey->getCas() . "]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";

//                      MISE EN CORELATION FUSEAU HORAIRE                   //
//        $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

//        dump($finalString);
//        $text = preg_replace('/\s\s+/', ' ', $finalString);
//        $finalStringForm = $this->createForm(FinalStringFormType::class);
//        $finalStringForm->handleRequest($request);

        return $this->render('Survey/forms/final_string_form.html.twig',[
//            'form' => $form->createView(),
//            'final_string_form' => $finalStringForm->createView(),
            'final_string' => $finalString,
        ]);
    }


    public function miseEnForm($text){
        if ( ($text == '') || ($text == ' ') ){
            return $text = null;
        }else{
            return $text . "\r\n";
        }
    }

    public function miseEnForm2($objects, $text){

        if (count($objects) != 0){
            $string = "[(" . count($objects) . ") " . $text;
            foreach ($objects as $key => $value){
                $key++;
                if ($key < count($objects)){
                    $object = $value->getBalise() . " (".$key.") - ";
                }else{
                    $object = $value->getBalise() . " (".$key.")";
                }

                $string .= $object;
            }
            $string .= "] ";

            return $string;
        }
    }

}
