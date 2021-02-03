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
     * @Route("/CODE-FINAL", name="final_string")
     */
    public function description(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController): Response
    {
        $survey = $surveySessionController->checkSurveySession();

        $finalString = '';

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
        $stringToHash = $finalString;


//        die();

        if ($survey->getCommentaire()){
            $finalString .= "[COMMENTAIRE_TECHNICIEN_" . $survey->getService() . " : " . $survey->getCommentaire() . "] ";
        }

        //                  Horodatage
        $survey->setTimeStamp();
        $horodatage = "[" . $survey->getTimeStamp()->format('d/m/Y - H:i') . "] ";
        $finalString .= "\r\n" . $horodatage;

        //         Hashage (crc32) de la chaine final
        $survey->setHashedString($stringToHash);
        $finalString .= "[" . strtoupper($survey->getHashedString()) . "] ";

        //                  Balise du INC ou DEM
        $finalString .= "[".$survey->getType()."] ";

        //                  Balise du service concerné (HD/SDP)
        $finalString .= "[".$survey->getService()."] ";

        $version = 2;
        $finalString .= '[ARBRE_DE_CLOTURE v.' . $version . "] " ;

//                      MISE EN CORELATION FUSEAU HORAIRE                   //
//        $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

//                         SUPPRESSION DES CHAINES VIDE                     //
//        $text = preg_replace('/\s\s+/', ' ', $finalString);

        $survey->setFinalString($finalString);

        $cheminController->setChemins($request);
        return $this->render('Survey/forms/final_string_form.html.twig',[
            'final_string' => $finalString,
            'survey' => $survey,
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
                dump($object);

                $balise .= "[";
                $key++;
                if ( $object == 'Rdv' || $object == 'Cmdb' ){
                    $balise .= $object->getBalise();
                }else{
                    $balise .= $object->getBalise() . "_" . $key;
                }



                if ($object == 'Asset' || $object == 'OtherAsset'){
                    if ($object->getAe() && $object->getAe() != 'XX' ){
                        $balise .= '<AE_' . $object->getAe() . '>';
                    }
                    if ($object->getAs() && $object->getAs() != 'XX' ){
                        $balise .= '<AS_' . $object->getAs() . '>';
                    }
                }elseif ($object == 'App' || $object == 'OtherApp' || $object == 'OtherAction'){
                    if ($object->getAsset() && $object->getAsset() != 'XX' ){
                        $balise .= '<ASSET_' . $object->getAsset() . '>';
                    }
                }elseif ($object == 'Rdv'){
                    if ($object->getRdvTotal()){
                        $balise .= '<NB_RDV_' . $object->getRdvTotal() . '>';
                    }
                    if ($object->getRdvKoScc()){
                        $balise .= '<NB_RDV_KOSCC_' . $object->getRdvKoScc() . '>';
                    }
                    if ($object->getRdvKoSafran()){
                        $balise .= '<NB_RDV_KOSF_' . $object->getRdvKoSafran() . '>';
                    }
                }elseif ($object == 'Cmdb'){
                    if ($object->getNbAction()){
                        $balise .= '<NB_' . $object->getNbAction() . '>';
                    }
                    if ($object->getAsset() && $object->getAsset() != 'XX' ){
                        $balise .= '<ASSET_' . $object->getAsset() . '>';
                    }
                }

                if ($object != 'Rdv'){
                    if ($object->getTpx()){
                        $balise .= '<TPX_' . $object->getTpx() . '>';
                    }
                    if ($object->getRsdp() && $object->getRsdp() != 'N/A' ){
                        $balise .= '<RSDP_' . $object->getRsdp() . '>';
                    }
                }



                $balise .= "] ";
            }
            return $balise;
        }

    }







}
