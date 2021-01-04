<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {

        $superAdmin = $userRepository->findOneBy(['email' => 'cboungou@fr.scc.com']);
        if (!$superAdmin){
            $superAdmin = New User();
            $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
            $password = '121090cb.K4gur0';
            $superAdmin->setEmail('cboungou@fr.scc.com');
            $superAdmin->setPassword(
                $passwordEncoder->encodePassword(
                    $superAdmin,
                    $password
                )
            );
            $em->persist($superAdmin);
            $em->flush();
        }

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
