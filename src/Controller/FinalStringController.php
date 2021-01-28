<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use Doctrine\ORM\EntityManagerInterface;
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
        $finalString .= "[" . $survey->getService() . "]";
        $finalString .= "[" . $survey->getCas() . "]";
        $finalString .= "\r\n[" . $survey->getTimeStamp()->format('d/m/Y - H:i:s') ."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";
//        $finalString .= "[".$survey->getService()."]";

//                      MISE EN CORELATION FUSEAU HORAIRE                   //
//        $survey->setTimeStamp(new \DateTime('', new \DateTimeZone('Europe/Paris') ) );

        //         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $finalString .= "\r\n[" . strtoupper($survey->getHashedString()) . "]";
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
