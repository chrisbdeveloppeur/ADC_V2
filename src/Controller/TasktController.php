<?php

namespace App\Controller;

use App\Form\AssetTypeFormType;
use App\Form\FromInctFormType;
use App\Form\HostnameFormType;
use App\Form\NewUserType;
use App\Form\TypeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("taskt/", name="taskt_")
 */
class TasktController extends AbstractController
{
    /**
     * @Route("from-inct", name="from_inct")
     */
    public function fromInct(Request $request): Response
    {
        $form = $this->createForm(FromInctFormType::class);
        $form->handleRequest($request);
        $from_inct = $form->get('from_inct')->getData();
//        $previousUrl = $request->headers->get('referer');
//        dd($request->getSession());
        if ($form->isSubmitted() && $form->isValid()){
            if ($from_inct == 'non'){
                return $this->redirectToRoute("taskt_asset_type",  [
                    'from_inct' => $from_inct,
                ]);
            }else{
                return $this->redirectToRoute("taskt_asset_type",  [
                    'from_inct' => $from_inct,
                ]);
            }

        }
        return $this->render('Survey/Taskt/from_inct_field.html.twig', [
            'form' => $form->createView(),
//            'previous_url' => $previousUrl,
        ]);
    }


    /**
     * @Route("from-inct={from_inct}/type-asset", name="asset_type")
     */
    public function setAssetType(Request $request, $from_inct): Response
    {
        $form = $this->createForm(AssetTypeFormType::class);
        $form->handleRequest($request);
//        $previousUrl = $request->headers->get('referer');
        $assetType = '?';

        if ($form->isSubmitted() && $form->isValid()){
            $assetType = $form->get("assetType")->getData();


            if ( $assetType == "Autre" ) {
//                $this->addFlash('info', 'Vous avez selectionner le type du matériel concerné : ' . $assetType);
                return $this->redirectToRoute("taskt_asset_type", [
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }elseif ( ($assetType == 'Desktop') || ($assetType == 'Laptop') ){
                return $this->redirectToRoute("taskt_type_taskt",[
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }else{
//                $this->addFlash('info', 'Vous avez selectionner le type du matériel concerné : ' . $assetType);
                return $this->redirectToRoute("taskt_hostname",[
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                    'new_user' => ' ',
                    'intervention' => ' ',
                ]);
            }

        }
        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
            'asset_type_field_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $assetType,
//            'previous_url' => $previousUrl,
        ]);
    }




    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention", name="type_taskt")
     */
    public function typeIntervention($from_inct, $asset_type, Request $request): Response
    {
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
//        $previousUrl = $request->headers->get('referer');
        if ($form->isSubmitted() && $form->isValid()){
            $intervention = $form->get('type')->getData();
            if ( ($intervention == 'Dotation') || ($intervention == 'Prêt') ){
                return $this->redirectToRoute('taskt_new_user',[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'intervention' => $intervention,
                ]);
            }elseif( ($intervention == "Restitution")){
                return $this->redirectToRoute('taskt_hostname',[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'intervention' => $intervention,
                    'new_user' => ' ',
                ]);
            }elseif( ($intervention == "Renouvellement")){
                return $this->redirectToRoute('taskt_hostname',[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'intervention' => $intervention,
                    'new_user' => ' ',
                ]);
            }
        }
        return $this->render('Survey/Taskt/type_field.html.twig', [
            'form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
//            'previous_url' => $previousUrl,
        ]);
    }



    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user", name="new_user")
     */
    public function newUser($from_inct, $asset_type, $intervention, Request $request): Response
    {
        $form = $this->createForm(NewUserType::class);
        $form->handleRequest($request);
//        $previousUrl = $request->headers->get('referer');

        if ($form->isSubmitted() && $form->isValid()){
            $newUser = $form->get('new_user')->getData();
            return $this->redirectToRoute('taskt_hostname',[
                'from_inct' => $from_inct,
                'asset_type' => $asset_type,
                'new_user' => $newUser,
                'intervention' => $intervention,
            ]);

        }
        return $this->render('Survey/Taskt/new_user.html.twig', [
            'form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
            'intervention' => $intervention,
//            'previous_url' => $previousUrl,
        ]);
    }


    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user={new_user}/hostname", name="hostname")
     */
    public function hostname(Request $request, $from_inct, $asset_type, $new_user, $intervention): Response
    {
        $form = $this->createForm(HostnameFormType::class);
        $form->handleRequest($request);
//        $previousUrl = $request->headers->get('referer');
        $assetType = $asset_type;


////////////////////////////////////////////////////////////////////////////////////////
///////////////////////       GESTION FICHIER CSV         //////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
        $csv = '..\public\csv\postes.csv';
        $arrayCsv = file($csv);
//        $file = fopen($csv, 'r');

        foreach ($arrayCsv as $key => $item){
            if ($item && ($key != 0)){
                $item = substr($item, 0, -2);
                $item = explode(';',$item);
//                $id = $item[0];
                $assetName = $item[1];
                $hostnames[] = $assetName;
            }
        }
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


        if ($form->isSubmitted() && $form->isValid()){

            $hostname = $_POST["hostname"];
            $customHostname = $form->get('customHostname')->getData();

            if ($hostname && !$customHostname){
//                $this->addFlash('info', 'Vous avez selectionner l\'asset : ' . $hostname);
                return $this->redirectToRoute("description",[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $hostname,
                    'intervention' => $intervention,
                    'new_user' => $new_user,
                ]);
            }elseif($customHostname){
//                $this->addFlash('info', 'Vous avez selectionner l\'asset : ' . $customHostname);

                return $this->redirectToRoute("description",[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $customHostname,
                    'intervention' => $intervention,
                    'new_user' => $new_user,
                ]);
            }elseif (!$hostname && !$customHostname){
                $this->addFlash('info', 'Veuillez indiquer un hostname pour continuer');
            }
        }

        return $this->render('Survey/hostname.html.twig', [
            'hostname_field_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $assetType,
            'assets' => $hostnames,
            'intervention' => $intervention,
            'new_user' => $new_user,
//            'previous_url' => $previousUrl,
        ]);
    }

}
