<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\HomeType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
        $form = $this->createForm(ServiceType::class,[
           'method' => 'POST'
        ]);
        $form->handleRequest($request);

//        if ($form->isSubmitted()){
//            dd($_POST);
//            return $this->redirectToRoute('q1');
//        }

        return $this->render('Survey/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/service", name="q1", methods={"POST"})
     */
    public function tasktOrInct(EntityManagerInterface $em)
    {

//        dd($_POST);
        if ($service == 'sdp'){
            return $this->render('Survey/sdp/type_inter.html.twig');
        }elseif ($service == 'hd'){
            return $this->render('Survey/service.html.twig');
        }else{
            return $this->render('Survey/service.html.twig');
        }
    }

    /**
     * @Route("/{tasktOrInct}/q2", name="q2")
     */
    public function typeInter($tasktOrInct,EntityManagerInterface $em)
    {
//        dd($_POST('type_form[type]'));
//        $user = $this->getUser();
//        $survey = $user->getSurvey();
//        $survey->setType($tasktOrInct);
//        $em->persist($survey);
        if ($tasktOrInct == 'taskt'){
            return $this->render('Survey/sdp/type_inter.html.twig',[
                'survey' => $survey,
            ]);
        }elseif ($tasktOrInct == 'inct'){
            return $this->render('Survey/service.html.twig');
        }else{
            return $this->render('Survey/service.html.twig');
        }
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
