<?php

namespace App\Controller;


use App\Entity\Asset;
use App\Entity\Survey;
use App\Form\AssetTypeFormType;
use App\Form\FinalStringFormType;
use App\Form\HostnameFormType;
use App\Form\TypeFormType;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="type")
     */
    public function type(Request $request, EntityManagerInterface $em, AssetRepository $assetRepository): Response
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
        $type = '?';

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
                return $this->redirectToRoute("type", [
                    'type' => $type,
                ]);
            }

        }
        return $this->render('Survey/type_field.html.twig', [
            'type_field_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{type}/from-inct={from_inct}/type-asset", name="asset_type")
     */
    public function setAssetType(Request $request, $type, $from_inct): Response
    {
        $form = $this->createForm(AssetTypeFormType::class);
        $form->handleRequest($request);
        $assetType = '?';

        if ($form->isSubmitted() && $form->isValid()){
            $assetType = $form->get("assetType")->getData();

            if ( ($assetType == "other") ){
                $this->addFlash('info', 'Vous avez selectionner le type d\'asset : ' . $assetType);
                return $this->redirectToRoute("asset_type",[
                    'type' => $type,
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }else{
                $this->addFlash('info', 'Vous avez selectionner le type d\'asset : ' . $assetType);
                return $this->redirectToRoute("hostname",[
                    'type' => $type,
                    'asset_type' => $assetType,
                    'from_inct' => $from_inct,
                ]);
            }

        }
        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
            'asset_type_field_form' => $form->createView(),
            'type' => $type,
            'from_inct' => $from_inct,
            'asset_type' => $assetType,
        ]);
    }



    /**
     * @Route("{type}/from-inct={from_inct}/{asset_type}/hostname", name="hostname")
     */
    public function hostname(Request $request, $type, $from_inct, $asset_type, AssetRepository $assetRepository): Response
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
                    'type' => $type,
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $hostname,
                ]);
            }elseif($customHostname){
                $this->addFlash('info', 'Vous avez selectionner l\'asset : ' . $customHostname);

                return $this->redirectToRoute("final_string",[
                    'type' => $type,
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $customHostname,
                ]);
            }elseif (!$hostname && !$customHostname){
                $this->addFlash('danger', 'Veuillez indiquer un hostname pour continuer');
            }


        }
        return $this->render('Survey/hostname.html.twig', [
            'hostname_field_form' => $form->createView(),
            'type' => $type,
            'from_inct' => $from_inct,
            'asset_type' => $assetType,
            'assets' => $assets,
        ]);
    }




    /**
     * @Route("{type}/{asset_type}/{hostname}/validation", name="final_string")
     */
    public function stringGen($type, $asset_type, $hostname): Response
    {
        $finalString = $type . " - " . $asset_type . " - " . $hostname;
        $survey = new Survey();
        // Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $finalString .= "\r\n[" . $survey->getHashedString() . "]";

        $survey->setFinalString($finalString);

        $form = $this->createForm(FinalStringFormType::class, $survey);
        return $this->render('Survey/final_string_form.html.twig', [
            'final_string_form' => $form->createView(),
            'type' => $type,
            'asset_type' => $asset_type,
            'hostname' => $hostname,
            'final_string' => $finalString,
        ]);
    }







    //    /**
//     * @Route("/refresh-CMDB", name="refresh_CMDB")
//     */
//    public function read(EntityManagerInterface $em, AssetRepository $assetRepository){
//        // Définir le chemin d'accès au fichier CSV
//        $csv = '..\public\csv\postes.csv';
//        $file = fopen($csv, 'r');
//        while (!feof($file) ) {
//            $line[] = fgetcsv($file);
//        }
//        for($i=1; $i<count($line)-1; $i++){
//            $array = $line[$i];
//            $result = explode(";", $array[0]);
//            $id = $result[0];
//            $hostname = $result[1];
//            $asset = new Asset();
//            if (!$assetRepository->findById($id)){
//                $asset->setHostname($hostname);
//                $asset->setIdentifiant($id);
//                $em->persist($asset);
//                $em->flush();
//            }
//        }
//        fclose($file);
//        $this->addFlash('success', 'Synchronisation avec la CMDB effectué');
//        return $this->redirectToRoute('type');
//    }

}
