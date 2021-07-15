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
        $version = 2.01;
        $survey =  $surveySessionController->checkSurveySession();
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

        $finalString = '';

        $assets = $survey->getAssets();
        $otherActions = $survey->getOtherActions();
        $otherAssets = $survey->getOtherAssets();
        $apps = $survey->getApps();
        $otherApps = $survey->getOtherApps();
        $phones = $survey->getPhones();
        $cmdbs = $survey->getCmdbs();
        $rsdp = $survey->getRsdp();
        if ($survey->getRdvs()[0]){
            $rdv = $survey->getRdvs()[0]->getBalise();
        }

        $finalString .= $this->miseEnFormBalise($assets);
        $finalString .= $this->miseEnFormBalise($otherActions);
        $finalString .= $this->miseEnFormBalise($otherAssets);
        $finalString .= $this->miseEnFormBalise($apps);
        $finalString .= $this->miseEnFormBalise($otherApps);
        $finalString .= $this->miseEnFormBalise($phones);
        $finalString .= $this->miseEnFormBalise($cmdbs);
        if (isset($rdv)){
            $finalString .= "[" . $rdv . "] ";
        }
        if ($rsdp == 'OUI' || $rsdp == 'NON'){
            $finalString .= "[RSDP_" . $rsdp . "] ";
        }

        $stringToHash = $finalString;

        $finalString = strtoupper($finalString);

        //      intégration et mise en forme de la balise commentaire si il a eu lieu
        if ($survey->getCommentaire()){
            $finalString .= "[COMMENTAIRE_TECHNICIEN_" . $survey->getService() . " : " . $survey->getCommentaire() . "] ";
        }

        //      intégration et mise en forme de la "balise ANNULE" si l'annulation a eu lieu
        if ($survey->getCanceled() == true){
            $finalString = "[ANNULE] ";
        }

        //      saut à la ligne dans la chaine de charactère
        $finalString .= "\r\n";

        //                  Balise "version ADC" qui apparait dans la chaine de balise
        $finalString .= '[ARBRE_DE_CLOTURE_V.' . $version . "] " ;

        //                  Horodatage
        $survey->setTimeStamp();
        $horodatage = "[" . $survey->getTimeStamp()->format('d/m/Y - H:i') . "] ";
        $finalString .= $horodatage;

        //         Hashage/Cryptage crc32 de la chaine balises final
        $survey->setHashedString($stringToHash);
        $finalString .= "[" . strtoupper($survey->getHashedString()) . "] ";

        //                  Récupération, et intégration dans la chaine, de la "balise INC ou DEM"
//        dd($survey->getType());
        if ( $survey->getType() != 'N/A' &&  $survey->getType() != null ){
            $finalString .= "[".$survey->getType()."] ";
        }

        //                  Récupération, et intégration dans la chaine, de la "balise USER_CMDB_DIF"
//        if ($survey->getUserCmdbDif() == 'OUI' || 'NON'){
        if ($survey->getUserCmdbDif() != null){
            $finalString .= "[USER_CMDB_DIF_".$survey->getUserCmdbDif()."] ";
        }

        //                  Récupération, et intégration dans la chaine, de la balise méthode intervention (PMAD/GUICHET/PLATEAU etc...)
        if ($survey->getResolveMethod() != null){
            $finalString .= "[".$survey->getResolveMethod()."] ";
        }

        //                  Récupération, et intégration dans la chaine, de la balise du service concerné (HD/SDP)
        $finalString .= "[".$survey->getService()."] ";

        /*      A GARDER
            //                      MISE EN CORELATION FUSEAU HORAIRE                   //
            $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

            //                       SUPPRESSION DES CHAINES VIDE                     //
            $text = preg_replace('/\s\s+/', ' ', $finalString);
        */

        //                  attribution de l'ensemble des balises dans la valeur final du formulaire -> correspond tout simplement a la chaine de balises final
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

            $objects = $objects->toArray();
            sort($objects);

            $balise = '';
            $nb = 0;

            foreach ($objects as $key => $object){
                $balise .= "[";
                if (isset($objects[$key - 1])){
                    if ($object->getBalise() != $objects[$key - 1]->getBalise()){
                        $nb = 0;
                    }else{
                        $nb++;
                    }
                    $key = $nb;
                }
                $key++;
                if ( $object == 'Rdv' || $object == 'Cmdb' ){
                    $balise .= $object->getBalise();
                }else{
                    if ($key == 1){
                        $balise .= $object->getBalise();
                    }else{
                        $balise .= $object->getBalise() . "_" . $key;
                    }
                }



                if ($object == 'Asset' || $object == 'OtherAsset'){
                    if ($object->getAe() ){
                        $balise .= '<AE_' . $object->getAe() . '>';
                    }
                    if ($object->getAs() ){
                        $balise .= '<AS_' . $object->getAs() . '>';
                    }
                }elseif ($object == 'App' || $object == 'OtherApp' || $object == 'OtherAction'){
                    if ($object->getAsset() ){
                        $balise .= '<ASSET_' . $object->getAsset() . '>';
                    }
                }elseif ($object == 'Cmdb'){
                    if ($object->getNbAction()){
                        $balise .= '<NB_' . $object->getNbAction() . '>';
                    }
                    if ($object->getAsset() ){
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
