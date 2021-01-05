<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LostPasswordType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Notif\NotifMessage;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
//    private $emailVerifier;
//
//    public function __construct(EmailVerifier $emailVerifier)
//    {
//        $this->emailVerifier = $emailVerifier;
//    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator, NotifMessage $notifMessage): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('admin@scc.com', 'admin scc'))
//                    ->to($user->getEmail())
//                    ->subject('Confirmer mon compte Arbre de clôture v1.9')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
            // do anything else you need here, like send an email
//            $this->addFlash('info', 'Votre compte a bien été créé ! Un mail de confirmation viens de vous être envoyer vers par Email');
//            return $guardHandler->authenticateUserAndHandleSuccess(
//                $user,
//                $request,
//                $authenticator,
//                'main' // firewall name in security.yaml
//            );
            $notifMessage->notifyRegistrationUser($user);
            $this->addFlash('info', 'Votre compte a bien été créé ! Un mail de confirmation viens de vous être envoyer vers par Email');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/verify/email", name="app_verify_email")
//     */
//    public function verifyUserEmail(Request $request): Response
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//
//        // validate email confirmation link, sets User::isVerified=true and persists
//        try {
//            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
//        } catch (VerifyEmailExceptionInterface $exception) {
//            $this->addFlash('verify_email_error', $exception->getReason());
//
//            return $this->redirectToRoute('home');
//        }
//
//        // @TODO Change the redirect on success and handle or remove the flash message in your templates
//        $this->addFlash('success', 'Votre compte à bien été valider');
//
//        return $this->redirectToRoute('home');
//    }


    /**
     * Confirmation du compte après inscription (lien envoyé par email)
     * @Route("/user-confirmation/{id}/{token}", name="user_confirmation")
     *
     * @param User                 $user          L'utilisateur qui tente de confirmer son compte
     * @param                       $token        Le jeton à vérifier pour confirmer le compte
     * @param EntityManagerInterface $entityManager Pour mettre à jour l'utilisateur
     */

    public function confirmAccount(User $user, $token, EntityManagerInterface $entityManager, NotifMessage $notifMessage)
    {
        // L'utilisateur a déjà confirmé son compte
        if ($user->isVerified()) {
            $this->addFlash('info', 'Votre inscription a déjà été validée');
            return $this->redirectToRoute('home');
        }

        // Le jeton ne correspond pas à celui de l'utilisateur
        if ($user->getSecurityToken() !== $token) {
            $this->addFlash('danger', 'Le jeton de sécurité est invalide');
            return $this->redirectToRoute('home');
        }

        // Le jeton est valide: mettre à jour le jeton et confirmer le compte
        $user->setIsVerified(true);
        $user->renewToken();

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte à bien été validée !');
        return $this->redirectToRoute('home');
    }


    /**
     * Demander un lien de réinitialisation du mot de passe
     * @Route("/lost-password", name="lost_password")
     *
     * @param Request         $request          Pour le formulaire
     * @param UserRepository  $userRepository   Pour rechercher l'utilisateur
     * @param MailerInterface $mailer           Pour envoyer l'email de réinitialisation
     */
    public function lostPassword(Request $request, UserRepository $userRepository, NotifMessage $notifMessage)
    {

        $lostPasswordForm = $this->createForm(LostPasswordType::class);
        $lostPasswordForm->handleRequest($request);

        if ($lostPasswordForm->isSubmitted() && $lostPasswordForm->isValid()) {
            $designedUser = $lostPasswordForm->get('email')->getData();

            $user = $userRepository->findOneBy(['email' => $designedUser]);

            if ($user === null) {
                $this->addFlash('danger', 'Cet adresse Email n\'est pas enregistrée');
            } else {


                $notifMessage->lostPassword($user);

                $this->addFlash('info', 'Un email de réinitialisation vient tout juste d\'être envoyé. Rendez-vous sur votre boite mail');
                return $this->redirectToRoute('app_login');

            }
        }

        return $this->render('security/lost_password.html.twig', [
            'lost_password_form' => $lostPasswordForm->createView()
        ]);
    }


    /**
     * Réinitialiser le mot de passe
     * @Route("/reset-password/{id}/{token}", name="reset_password")
     *
     * @param User                          $user            L'utilisateur qui souhaite réinitialiser son mot de passe
     * @param                               $token           Le jeton à vérifier pour la réinitialisation
     * @param Request                       $request         Pour le formulaire de réinitialisation
     * @param EntityManagerInterface        $entityManager   Pour mettre à jour l'utilisateur
     * @param UserPasswordEncoderInterface $passwordEncoder Pour hasher le nouveau mot de passe
     */
    public function resetPassword(
        User $user,
        $token,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        // Le jeton ne correspond pas à celui de l'utilisateur
        if ($user->getSecurityToken() !== $token) {
            $this->addFlash('danger', 'Le jeton de sécurité est invalide.');
            return $this->redirectToRoute('app_login');
        }

        // Création du formulaire de réinitialisation du mot de passe
        $resetForm = $this->createForm(ResetPasswordType::class);
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            $password = $resetForm->get('plainPassword')->getData();

            $oldPassword = $passwordEncoder->isPasswordValid($user, $password);

            if($oldPassword === false){
                $user->setPassword($passwordEncoder->encodePassword($user, $password));
                $user->renewToken();

                // Mise à jour de l'entité en BDD

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // Ajout d'un message flash
                $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
                return $this->redirectToRoute('app_login');
            }else{
                $this->addFlash('danger', 'Votre mot de passe doit être différent de l\'ancien');
            }

        }

        return $this->render('security/reset_password.html.twig', [
            'reset_form' => $resetForm->createView()
        ]);
    }


}
