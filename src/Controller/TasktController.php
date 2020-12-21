<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasktController extends AbstractController
{
    /**
     * @Route("{type}/type-peripherique", name="taskt")
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
}
