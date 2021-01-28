<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Form\AssetsType;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * Class HomeController
// * @package App\Controller
// * @IsGranted("ROLE_USER")
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
//            dd($reponse);
            if ($reponse == 'HD'){
                return $this->redirectToRoute('home',[
                    'service' => $reponse,
                ]);
            }elseif ($reponse == 'SDP'){
                return $this->redirectToRoute('tasktorinct',[
                    'service' => $reponse,
                ]);
            }

        }

        return $this->render('Survey/home/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/taskt-or-inct", name="tasktorinct")
     */
    public function tasktOrInct(Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $survey->setType(null);
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $reponse = $form->get('type')->getData();
            $survey->setType($reponse);
            if ($reponse == 'DEM'){
                return $this->redirectToRoute('taskt_home');
            }elseif ($reponse == 'INC'){
                return $this->redirectToRoute('inct_home');
            }
        }
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
        ]);
    }



//    /**
//     * @Route("/type", name="inct")
//     */
//    public function typeInct(Request $request)
//    {
//        $survey = $this->get('session')->get('survey');
//        $type = $survey->getType();
//        if ($type == "INC"){
//            $form = $this->createForm(TypeInterInctForm::class);
//        }elseif ($type == 'DEM'){
//            $form = $this->createForm(TypeInterTasktForm::class);
//        }
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted()){
//            $reponse = $form->get('choices')->getData();
//            $survey->setTypeInter($reponse);
//            if ($reponse == 'inct_1'){         /* Changement de PC */
//                return $this->redirectToRoute('form_asset',[
//                    'reponse' => $reponse,
//                ]);
//            }elseif ($reponse == 'inct_2' ){   /* Autre intervention matérielle */
//                return $this->redirectToRoute('inct');
//            }elseif($reponse == 'inct_3'){                      /* Intervention software */
//                return $this->redirectToRoute('inct',[
//                    'tasktorinct' => $reponse,
//                ]);
//            }
//        }

//        return $this->render('Survey/sdp/type_inter.html.twig',[
//            'form' => $form->createView(),
//            'form_name' => $form->getName(),
//        ]);
//
//    }





//    /**
//     * @Route("/asset-form", name="asset_form")
//     */
//    public function assetForm(Request $request): Response
//    {
//        $form = $this->createForm(AssetsType::class);
//        $assetForm = $this->createForm(AssetType::class);
//        $survey = $this->get('session')->get('survey');
//        $form->handleRequest($request);
//        $assetForm->handleRequest($request);
//        for ($i=0; $i<=count($survey->getAssets()); $i++ ){
//            $number = $i;
//        }
////
//        if ($assetForm->isSubmitted() && $number<=10){
//            $newAsset = new Asset();
//            $newAsset->setSurvey($survey);
//            $newAsset->setPosition($number);
//            $newAsset->setCurrentHostname($assetForm->get('as')->getData());
//            $newAsset->setNewHostname($assetForm->get('ae')->getData());
//            $newAsset->setType($assetForm->get('type')->getData());
//            $newAsset->setAction($assetForm->get('action')->getData());
//            if ( ($newAsset->getAction()=="DEM_PDT") || ($newAsset->getAction()=="PRT_PCF") ){
//                $newAsset->setType(null);
//            }
//            $newAsset->setRsdp($assetForm->get('rspd')->getData());
//            $newAsset->setDuree($assetForm->get('tpx')->getData());
//            if ($newAsset->getNewHostname()==null){
//                $newAsset->setNewHostname('N/A');
//            }
//            if ($newAsset->getCurrentHostname()==null){
//                $newAsset->setCurrentHostname('N/A');
//            }
//            $survey->addAsset($newAsset);
//
//            $action = $assetForm->get('action')->getData();
//            $type = $assetForm->get('type')->getData();
//            $ae = $assetForm->get('ae')->getData();
//            $as = $assetForm->get('ae')->getData();
//
//            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//            return $this->redirect($referer);
////            return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as]);
//        }
//
//        if ($form->isSubmitted()){
////            return $this->redirectToRoute();
//        }
//
//        return $this->render('Survey/assets_form.html.twig',[
//            'form' => $form->createView(),
//            'form_name' => $form->getName(),
//            'asset_form' => $assetForm->createView(),
//            'survey' => $survey,
//        ]);
//    }






//    /**
//     * @Route("/add-asset", name="add_asset")
//     */
//    public function addAsset(Request $request): Response
//    {
//        $survey = $this->get('session')->get('survey');
////        dd($survey);
//        for ($i=0; $i<=count($survey->getAssets()); $i++ ){
//            $number = $i;
//        }
//
////            $newAsset = new Asset();
////            $newAsset->setSurvey($survey);
////            $newAsset->setPosition($number);
////            $newAsset->setCurrentHostname($assetForm->get('as')->getData());
////            $newAsset->setNewHostname($assetForm->get('ae')->getData());
////            $newAsset->setType($assetForm->get('type')->getData());
////            $newAsset->setAction($assetForm->get('action')->getData());
////            if ( ($newAsset->getAction()=="DEM_PDT") || ($newAsset->getAction()=="PRT_PCF") ){
////                $newAsset->setType(null);
////            }
////            $newAsset->setRsdp($assetForm->get('rspd')->getData());
////            $newAsset->setDuree($assetForm->get('tpx')->getData());
////            if ($newAsset->getNewHostname()==null){
////                $newAsset->setNewHostname('N/A');
////            }
////            if ($newAsset->getCurrentHostname()==null){
////                $newAsset->setCurrentHostname('N/A');
////            }
////            $survey->addAsset($newAsset);
//
//            return $this->json($survey);
//
//    }


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








//    public function miseEnForm($text, $info){
//        if ( ($text == 'skipped') || ($text == '') || ($text == ' ') ){
//            return $text = null;
//        }else{
//            $text = $info . $text;
//            return $text . "\r\n";
//        }
//    }
//
//    /**
//     * @Route("/validation", name="final_string")
//     * @IsGranted("ROLE_USER")
//     */
//    public function stringGen(): Response
//    {
//        $survey = $this->getUser()->getSurvey();
//        $textDescription = $survey->getDescription();
//        $text = preg_replace('/\s\s+/', ' ', $textDescription);
//
//        $from_inct = $this->miseEnForm($survey->getFromInct(), 'Suite à incident : ');
//        $asset_type = $this->miseEnForm($survey->getAssetType(), 'Type de matériel : ');
//        $new_user = $this->miseEnForm($survey->getNewUser(),'Nouvel arrivant : ');
//        $hostname = $this->miseEnForm($survey->getHostname(),'Hostname : ');
//        $intervention = $this->miseEnForm($survey->getType(),'Type d\'intervention : ');
//        $description = $this->miseEnForm($survey->getDescription(), 'Déscription : ');
//
//        $finalString = [$from_inct, $asset_type, $new_user, $hostname, $intervention, $description] ;
//        foreach ($finalString as $key => $value){
//            if ($value == null){
//                unset($finalString[$key]);
//            }
//        }
//        $finalString = implode($finalString);
//
//        $survey = new Survey();
////         Hashage (crc32) de la chaine final
//        $survey->setHashedString($finalString);
//        $date = $survey->getDateString();
//        $date = $date->format('d/m/Y - H:i');
//        $finalString .= "[" . $date . "]";
//        $finalString .= "\r\n[" . $survey->getHashedString() . "]";
//
//        $survey->setFinalString($finalString);
//
//        $form = $this->createForm(FinalStringFormType::class, $survey);
//        return $this->render('Survey/final_string_form.html.twig', [
//            'final_string_form' => $form->createView(),
//            'from_inct' => $from_inct,
//            'asset_type' => $asset_type,
//            'intervention' => $intervention,
//            'new_user' => $new_user,
//            'hostname' => $hostname,
//            'final_string' => $finalString,
//        ]);
//    }



}
