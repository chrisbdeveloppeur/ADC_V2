<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
//            ->add('agreeTerms', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'You should agree to our terms.',
//                    ]),
//                ],
//            ])
            ->add('plainPassword', RepeatedType::class, [
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
                'label' => false,
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'required' => true,
                'error_bubbling' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez remplir ce champ.']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
