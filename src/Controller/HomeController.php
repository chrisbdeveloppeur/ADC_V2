<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use App\Form\TypeInterTasktForm;
use App\Form\TypeInterInctForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * Class HomeController
// * @package App\Controller
// *
// */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $survey = new Survey();

        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);
        $this->get('session')->set('survey', $survey);
        if ($form->isSubmitted()){
            $reponse = $form->get('service')->getData();
            $survey->setService($reponse);
            return $this->redirectToRoute('q1',[
                'service' => $reponse,
            ]);
        }

        return $this->render('Survey/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{service}", name="q1")
     */
    public function tasktOrInct(EntityManagerInterface $em, $service, Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $reponse = $form->get('choices')->getData();
            $survey->setType($reponse);
            return $this->redirectToRoute('q2',[
                'service' => $service,
                'tasktorinct' => $reponse,
            ]);
        }
        return $this->render('Survey/sdp/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
        ]);
    }

    /**
     * @Route("/{service}/{tasktorinct}", name="q2")
     */
    public function typeInter($tasktorinct, $service, EntityManagerInterface $em, Request $request)
    {
        $survey = $this->get('session')->get('survey');
        if ($tasktorinct == "inct"){
            $form = $this->createForm(TypeInterInctForm::class);
        }elseif ($tasktorinct == 'taskt'){
            $form = $this->createForm(TypeInterTasktForm::class);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $reponse = $form->get('choices')->getData();
//            $survey->set($reponse);
            dd($survey);
            if ($reponse == 1){         /* Changement de PC */
                return $this->redirectToRoute('q2',[
                    'service' => $service,
                    'tasktorinct' => $reponse,
                ]);
            }elseif ($reponse == 2 ){   /* Autre intervention matérielle */
                return $this->redirectToRoute('q2',[
                    'service' => $service,
                    'tasktorinct' => $reponse,
                ]);
            }else{                      /* Intervention software */
                return $this->redirectToRoute('q2',[
                    'service' => $service,
                    'tasktorinct' => $reponse,
                ]);
            }

        }

        return $this->render('Survey/sdp/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
        ]);

    }

    /**
     * @Route("/description", name="description")
     */
    public function description(Request $request, EntityManagerInterface $em): Response
    {
        $survey = $this->getUser()->getSurvey();
        $form = $this->createForm(DescriptionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                $infos = $form->get('infos')->getData();
                $survey->setDescription($infos);
                $em->persist($survey);
                $em->flush();
                return $this->redirectToRoute("final_string");

        }
        return $this->render('Survey/description_form.html.twig',[
            'description_form' => $form->createView(),
        ]);
    }




    public function miseEnForm($text, $info){
        if ( ($text == 'skipped') || ($text == '') || ($text == ' ') ){
            return $text = null;
        }else{
            $text = $info . $text;
            return $text . "\r\n";
        }
    }
    /**
     * @Route("/validation", name="final_string")
     * @IsGranted("ROLE_USER")
     */
    public function stringGen(): Response
    {
        $survey = $this->getUser()->getSurvey();
        $textDescription = $survey->getDescription();
        $text = preg_replace('/\s\s+/', ' ', $textDescription);

        $from_inct = $this->miseEnForm($survey->getFromInct(), 'Suite à incident : ');
        $asset_type = $this->miseEnForm($survey->getAssetType(), 'Type de matériel : ');
        $new_user = $this->miseEnForm($survey->getNewUser(),'Nouvel arrivant : ');
        $hostname = $this->miseEnForm($survey->getHostname(),'Hostname : ');
        $intervention = $this->miseEnForm($survey->getType(),'Type d\'intervention : ');
        $description = $this->miseEnForm($survey->getDescription(), 'Déscription : ');

        $finalString = [$from_inct, $asset_type, $new_user, $hostname, $intervention, $description] ;
        foreach ($finalString as $key => $value){
            if ($value == null){
                unset($finalString[$key]);
            }
        }
        $finalString = implode($finalString);

        $survey = new Survey();
//         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $date = $survey->getDateString();
        $date = $date->format('d/m/Y - H:i');
        $finalString .= "[" . $date . "]";
        $finalString .= "\r\n[" . $survey->getHashedString() . "]";

        $survey->setFinalString($finalString);

        $form = $this->createForm(FinalStringFormType::class, $survey);
        return $this->render('Survey/final_string_form.html.twig', [
            'final_string_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
            'intervention' => $intervention,
            'new_user' => $new_user,
            'hostname' => $hostname,
            'final_string' => $finalString,
        ]);
    }



}
