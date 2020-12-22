<?php

namespace App\Controller;


use App\Entity\Asset;
use App\Form\AssetTypeFormType;
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
     * @Route("/refresh-CMDB", name="refresh_CMDB")
     */
    public function read(EntityManagerInterface $em, AssetRepository $assetRepository){
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
        $this->addFlash('success', 'Synchronisation avec la CMDB effectué');
        return $this->redirectToRoute('type');
    }
        // Définir le chemin d'accès au fichier CSV

    /**
     * @Route("/", name="type")
     */
    public function type(Request $request, EntityManagerInterface $entityManager): Response
    {


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





    /**
     * @Route("{type}/type-asset", name="final_string")
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
