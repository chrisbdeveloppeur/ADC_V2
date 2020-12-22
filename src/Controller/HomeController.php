<?php

namespace App\Controller;


use App\Entity\Asset;
use App\Form\AssetTypeFormType;
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
        while (!feof($file) ) {
            $line[] = fgetcsv($file);
        }
        for($i=1; $i<count($line)-1; $i++){
            $array = $line[$i];
            $result = explode(";", $array[0]);
            $id = $result[0];
            $hostname = $result[1];
            $asset = new Asset();
            if (!$assetRepository->findById($id)){
                $asset->setHostname($hostname);
                $asset->setIdentifiant($id);
                $em->persist($asset);
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

            $this->addFlash('success', $type . ' selectionné !');

            if ($type == "demande"){
                return $this->redirectToRoute("asset_type",  [
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
     * @Route("{type}/type-asset", name="asset_type")
     */
    public function setAssetType(Request $request, $type): Response
    {
        $form = $this->createForm(AssetTypeFormType::class);
        $form->handleRequest($request);
        $assetType = '?';

        if ($form->isSubmitted() && $form->isValid()){
            $assetType = $form->get("assetType")->getData();

            if ( ($assetType == "other") ){
                $this->addFlash('success', 'Le type' . $assetType . ' à été selectionné !');
                return $this->redirectToRoute("asset_type",[
                    'type' => $type,
                    'asset_type' => $assetType,
                ]);
            }else{
                $this->addFlash('success', $assetType . ' selectionné !');
                return $this->redirectToRoute("hostname",[
                    'type' => $type,
                    'asset_type' => $assetType,
                ]);
            }

        }
        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
            'asset_type_field_form' => $form->createView(),
            'type' => $type,
            'asset_type' => $assetType,
        ]);
    }



    /**
     * @Route("{type}/{asset_type}/hostname", name="hostname")
     */
    public function hostname(Request $request, $type, $asset_type, AssetRepository $assetRepository): Response
    {
        $form = $this->createForm(HostnameFormType::class);
        $form->handleRequest($request);
        $assetType = $asset_type;
        $assets = $assetRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()){


            $hostname = $form->get("newAsset")->getData();
            $hostname = $hostname->getHostname();
                $this->addFlash('success', $hostname . ' selectionné !');

                return $this->redirectToRoute("type",[
                    'type' => $type,
                    'asset_type' => $asset_type,
                    'hostname' => $hostname,
                ]);

        }
        return $this->render('Survey/hostname.html.twig', [
            'hostname_field_form' => $form->createView(),
            'type' => $type,
            'asset_type' => $assetType,
            'assets' => $assets,
        ]);
    }




    /**
     * @Route("validation/", name="final_string")
     */
    public function stringGen(Request $request, $type): Response
    {
        $form = $this->createForm(AssetTypeFormType::class);
        $form->handleRequest($request);
        $assetType = '?';

        if ($form->isSubmitted() && $form->isValid()){
//            $user = $form->getData();
//            $entityManager->persist($user);
            $assetType = $form->get("assetType")->getData();

            if ( ($assetType == "other") ){
                $this->addFlash('success', 'Le type' . $assetType . ' à été selectionné !');
//                dd($type, $assetType);
                return $this->redirectToRoute("asset_type",[
                    'type' => $type,
                    'asset_type' => $assetType,
                ]);
            }else{
                $this->addFlash('success', $assetType . ' selectionné !');
//                dd($type, $assetType);
                return $this->redirectToRoute("asset_type",[
                    'type' => $type,
                    'asset_type' => $assetType,
                ]);
            }

        }
        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
            'asset_type_field_form' => $form->createView(),
            'type' => $type,
            'asset_type' => $assetType,
        ]);
    }
}
