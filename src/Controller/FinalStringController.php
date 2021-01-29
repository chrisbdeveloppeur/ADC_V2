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
        $survey->setTimeStamp();
        $horodatage = $survey->getTimeStamp()->format('d/m/Y - H:i');
        $finalString .= $horodatage;

        //         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $finalString .= " - [" . strtoupper($survey->getHashedString()) . "]\r\n";

        $assets = $survey->getAssets();
        $otherAssets = $survey->getOtherAssets();
        $apps = $survey->getApps();

        $finalString .= $this->miseEnFormBalise($assets, '');
        $finalString .= $this->miseEnFormBalise($otherAssets, '');
        $finalString .= $this->miseEnFormBalise($apps, '');

//        die();

        if ($survey->getCommentaire()){
            $finalString .= "[COMMENTAIRE_TECHNICIEN_" . $survey->getService() . " : " . $survey->getCommentaire() . "]";
        }
//        $finalString .= "[" . $survey->getCas() . "]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";


//                      MISE EN CORELATION FUSEAU HORAIRE                   //
//        $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

//                         SUPPRESSION DES CHAINES VIDE                     //
//        $text = preg_replace('/\s\s+/', ' ', $finalString);

        $survey->setFinalString($finalString);

//        dump($survey);
//        dd($survey->getFinalString());
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

    public function miseEnFormBalise($objects, $text){

        if (count($objects) != 0){

            foreach ($objects as $key => $object){

                $string = "[" . $text;
//                $key++;
                $string .= $object->getBalise() . "_" . $object->getPosition();

                if ($object == 'Asset' || $object == 'OtherAsset'){
                        if ($object->getAe() && $object->getAe() != 'N/A' ){
                            $string .= '<AE_' . $object->getAe() . '>';
                        }
                        if ($object->getAs() && $object->getAs() != 'N/A' ){
                            $string .= '<AS_' . $object->getAs() . '>';
                        }
                }elseif ($object == 'App'){
                    if ($object->getAsset() && $object->getAsset() != 'N/A' ){
                        $string .= '<ASSET_' . $object->getAsset() . '>';
                    }
                }

                $string .= "] ";
            }

//            dump($string);

            return $string;
        }
    }







}
