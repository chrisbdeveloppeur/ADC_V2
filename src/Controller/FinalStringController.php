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
        $finalString .= " - [" . strtoupper($survey->getHashedString()) . "]";
        $finalString .= " [".$survey->getService()."]\r\n";

        $assets = $survey->getAssets();
        $otherActions = $survey->getOtherActions();
        $otherAssets = $survey->getOtherAssets();
        $apps = $survey->getApps();
        $otherApps = $survey->getOtherApps();
        $phones = $survey->getPhones();
        $cmdbs = $survey->getCmdbs();
        $rdvs = $survey->getRdvs();

        $finalString .= $this->miseEnFormBalise($assets);
        $finalString .= $this->miseEnFormBalise($otherActions);
        $finalString .= $this->miseEnFormBalise($otherAssets);
        $finalString .= $this->miseEnFormBalise($apps);
        $finalString .= $this->miseEnFormBalise($otherApps);
        $finalString .= $this->miseEnFormBalise($phones);
        $finalString .= $this->miseEnFormBalise($cmdbs);
        $finalString .= $this->miseEnFormBalise($rdvs);

        if ($survey->getCommentaire()){
            $finalString .= "[COMMENTAIRE_TECHNICIEN_" . $survey->getService() . " : " . $survey->getCommentaire() . "]";
        }


//                      MISE EN CORELATION FUSEAU HORAIRE                   //
//        $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

//                         SUPPRESSION DES CHAINES VIDE                     //
//        $text = preg_replace('/\s\s+/', ' ', $finalString);

        $survey->setFinalString($finalString);

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

    public function miseEnFormBalise($objects){

        if (count($objects) != 0){

            $balise = '';

            foreach ($objects as $key => $object){

                $balise .= "[";
                $key++;
                $balise .= $object->getBalise() . "_" . $key;

                if ($object == 'Asset' || $object == 'OtherAsset'){
                    if ($object->getAe() && $object->getAe() != 'N/A' ){
                        $balise .= '<AE_' . $object->getAe() . '>';
                    }
                    if ($object->getAs() && $object->getAs() != 'N/A' ){
                        $balise .= '<AS_' . $object->getAs() . '>';
                    }
                }elseif ($object == 'App' || $object == 'OtherApp' || $object == 'OtherAction'){
                    if ($object->getAsset() && $object->getAsset() != 'N/A' ){
                        $balise .= '<ASSET_' . $object->getAsset() . '>';
                    }
                }

                $balise .= "] ";
            }
            return $balise;
        }
    }







}
