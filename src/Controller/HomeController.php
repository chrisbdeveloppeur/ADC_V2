<?php

namespace App\Controller;


use App\Form\TypeFormType;
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
    public function type(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager->persist($user);
            $type = $form->get("type")->getData();

            $this->addFlash('success', $user->getType() . ' selectionné !');

            if ($type == "demande"){
                return $this->redirectToRoute("type",  [
                    'type' => $type,
                ]);
            }else{
                return $this->redirectToRoute("asset", [
                    'type' => $type,
                ]);
            }

        }
        return $this->render('Survey/type_field.html.twig', [
            'type_field_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{type}/last_name", name="last_name")
     */
    public function setLastName(Request $request, EntityManagerInterface $entityManager, $type): Response
    {
        $form = $this->createForm(LastNameFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager->persist($user);
            $lastName = $form->get("lastName")->getData();

            if ( ($lastName == "christian") || ($lastName == "jeremie") ){
                $this->addFlash('success', $user->getLastName() . ' selectionné !');
                dd($type, $lastName);
                return $this->redirectToRoute("home");
            }else{
                $this->addFlash('success', $user->getLastName() . ' selectionné !');
                dd($type, $lastName);
                return $this->redirectToRoute("home");
            }

        }
        return $this->render('Survey/last_name_field.html.twig', [
            'last_name_field_form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/location", name="location")
     */
}
