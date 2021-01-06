<?php


namespace App\Notif;

use App\Entity\User;
use Twig\Environment;

class NotifMessage
{

    /**
     * NotifMessageconstructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notifyRegistrationUser(User $user)
    {
        $message = (new \Swift_Message('Arbre de clôture v1.9 - Mail de confirmation pour la création de compte'))
            ->setFrom('admin@scc-tool.com')
            ->setTo($user->getEmail())
//            ->setTo('kenshin91cb@gmail.com')
            ->setBody($this->renderer->render('emails/confirmation_user.html.twig',[
                'user' => $user,
            ]), 'text/html' );
        $this->mailer->send($message);
    }

    public function lostPassword(User $user)
    {
//         Création de l'email de réinitialisation
        $message = (new \Swift_Message('Arbre de clôture v1.9 - Réinitialisation de votre mot de passe'))
            ->setFrom('admin@scc-tool.com')
            ->setTo($user->getEmail())
//                ->setTo('kenshin91cb@gmail.com')
            ->setBody($this->renderer->render('emails/reset_password.html.twig',[
                'user' => $user,
            ]), 'text/html' );
        $this->mailer->send($message);
    }

}