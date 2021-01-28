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

        foreach ($apps as $key => $value){
//            dump($value->getBalise());
            $key++;
            $app = "[" . $value->getBalise() . "(".$key.")] ";
            $finalString .= $app;
            dump($app);
        }
        foreach ($assets as $key => $value){
//            dump($value->getBalise());
            $key++;
            $assets = "[" . $value->getBalise() . "(".$key.")] ";
            $finalString .= $assets;
            dump($assets);
        }
        foreach ($otherAssets as $key => $value){
//            dump($value->getBalise());
            $key++;
            $otherAssets = "[" . $value->getBalise() . "(".$key.")] ";
            $finalString .= $otherAssets;
            dump($otherAssets);
        }
//dd($finalString);
        $em->persist($survey);

//        dd($survey);

//        $finalString .= "[" . $survey->getService() . "]";
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


}
