<?php

namespace App\Controller;


use App\Entity\Asset;
use App\Entity\Survey;
use App\Form\AssetTypeFormType;
use App\Form\FinalStringFormType;
use App\Form\HostnameFormType;
use App\Form\NewUserType;
use App\Form\TypeFormType;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, EntityManagerInterface $em, AssetRepository $assetRepository): Response
    {
//////////////////////////////////////////////////////////////////////////////////////
/////////////////////       GESTION FICHIER CSV         //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
        // Définir le chemin d'accès au fichier CSV
        $csv = '..\public\csv\postes.csv';
        $file = fopen($csv, 'r');
        // Transformation de chaques ligne du CSV dans un tableau
        while (!feof($file) ) {
            $line[] = fgetcsv($file);
        }
        $assetsFromBDD = $assetRepository->findAll();
        //Décomponsition du tableau
        for($i=1; $i<count($line)-1; $i++){
            $array = $line[$i];
            $result = explode(";", $array[0]);
            $id = $result[0];
            $ids[] = $id;
            $hostname = $result[1];
            // Ajoute un asset en BDD via le fichier CSV
            if (!$assetRepository->findById($id)){
                $asset = new Asset();
                $asset->setHostname($hostname);
                $asset->setIdentifiant($id);
                $em->persist($asset);
                $em->flush();
            }
            $asset = $assetRepository->findById($id)[0];
            $hostnameFromBDD = $asset->getHostname();
            //Synchronise les modifications des Assets entre le CSV et la BDD
            if ($hostname != $hostnameFromBDD){
                $asset->setHostname($hostname);
                $em->persist($asset);
                $em->flush();
            }
        }

        //Synchronise les suppression des Assets entre le CSB et la BDD
        foreach ( $assetsFromBDD as $item){
            if (!in_array($item->getIdentifiant(), $ids)){
                $assetToRemove = $assetRepository->findById($item->getIdentifiant());
                $em->remove($assetToRemove[0]);
                $em->flush();
            }

        }
        fclose($file);
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
//        $type;

        if ($form->isSubmitted() && $form->isValid()){
//            $user = $form->getData();
//            $entityManager->persist($user);
            $type = $form->get("type")->getData();

            $this->addFlash('info', $type . ' selectionné !');

            if ($type == "demande"){
                return $this->redirectToRoute("taskt_from_inct",  [
                    'type' => $type,
                ]);
            }else{
                return $this->redirectToRoute("home", [
                    'type' => $type,
                ]);
            }

        }
        return $this->render('Survey/home.html.twig');
    }






    /**
     * @Route("from-inct={from_inct}/type-asset", name="asset_type")
     */
    public function setAssetType(Request $request, $from_inct): Response
    {
        $form = $this->createForm(AssetTypeFormType::class);
        $form->handleRequest($request);
        $assetType = '?';

        if ($form->isSubmitted() && $form->isValid()){
            $assetType = $form->get("assetType")->getData();


            if ( $assetType == "Autre" ) {
//                $this->addFlash('info', 'Vous avez selectionner le type du matériel concerné : ' . $assetType);
                return $this->redirectToRoute("asset_type", [
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }elseif ( ($assetType == 'Desktop') || ($assetType == 'Laptop') ){
                return $this->redirectToRoute("type_taskt",[
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }else{
//                $this->addFlash('info', 'Vous avez selectionner le type du matériel concerné : ' . $assetType);
                return $this->redirectToRoute("hostname",[
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
        ]);
    }




    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention", name="type_taskt")
     */
    public function typeIntervention($from_inct, $asset_type, Request $request): Response
    {
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $intervention = $form->get('type')->getData();
            if ( ($intervention == 'Dotation') || ($intervention == 'Prêt') ){
                return $this->redirectToRoute('new_user',[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'intervention' => $intervention,
                ]);
            }
        }
        return $this->render('Survey/Taskt/type_field.html.twig', [
            'form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
        ]);
    }



    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user", name="new_user")
     */
    public function newUser($from_inct, $asset_type, $intervention, Request $request): Response
    {
        $form = $this->createForm(NewUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newUser = $form->get('new_user')->getData();
            return $this->redirectToRoute('hostname',[
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
        ]);
    }


    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user={new_user}/hostname", name="hostname")
     */
    public function hostname(Request $request, $from_inct, $asset_type, $new_user, $intervention, AssetRepository $assetRepository): Response
    {
        $form = $this->createForm(HostnameFormType::class);
        $form->handleRequest($request);
        $assetType = $asset_type;
        $assets = $assetRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()){

            $hostname = $form->get("newAsset")->getData();
            $customHostname = $form->get('customHostname')->getData();

            if ($hostname && !$customHostname){
                $this->addFlash('info', 'Vous avez selectionner l\'asset : ' . $hostname);

                return $this->redirectToRoute("final_string",[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $hostname,
                    'intervention' => $intervention,
                    'new_user' => $new_user,
                ]);
            }elseif($customHostname){
                $this->addFlash('info', 'Vous avez selectionner l\'asset : ' . $customHostname);

                return $this->redirectToRoute("final_string",[
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $customHostname,
                    'intervention' => $intervention,
                    'new_user' => $new_user,
                ]);
            }elseif (!$hostname && !$customHostname){
                $this->addFlash('danger', 'Veuillez indiquer un hostname pour continuer');
            }


        }
        return $this->render('Survey/hostname.html.twig', [
            'hostname_field_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $assetType,
            'assets' => $assets,
            'intervention' => $intervention,
            'new_user' => $new_user,
        ]);
    }



    public function miseEnForm($text, $info){
        if ($text != " "){
            $text = $info . $text;
            return $text . "\r\n";
        }else{
            return $text = null;
        }
    }
    /**
     * @Route("{from_inct}/{asset_type}/{intervention}/{new_user}/{hostname}/validation", name="final_string")
     */
    public function stringGen($from_inct ,$asset_type, $new_user, $hostname, $intervention): Response
    {
        $from_inct = $this->miseEnForm($from_inct, 'Suite à incident : ');
        $asset_type = $this->miseEnForm($asset_type, 'Type de matériel : ');
        $new_user = $this->miseEnForm($new_user,'Nouvel arrivant : ');
        $hostname = $this->miseEnForm($hostname,'Hostname : ');
        $intervention = $this->miseEnForm($intervention,'Type d\'intervention : ');

        $finalString = [$from_inct, $asset_type, $new_user, $hostname, $intervention] ;
        foreach ($finalString as $key => $value){
            if ($value == null){
                unset($finalString[$key]);
            }
        }
        $finalString = implode($finalString);

        $survey = new Survey();
//         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
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
