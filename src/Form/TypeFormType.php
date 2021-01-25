<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tasktorinct', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
//                'choice_label' => false,
                    'choices' => [
                        'Demande' => 'taskt',
                        'incident' => 'inct',

                        //                        'Hardware' => [
//                            'Dotation de poste' => 'Dotation',
//                            'Prêt de poste' => 'Prêt',
//                            'Restitution' => 'Restitution',
//                            'Renouvellement' => 'Renouvellement',
//                            'Déménagement' => 'Déménagement',
//                        ],
//                        'Software' => [
//                            'Installation logiciel' => 'Installation',
//                            'Desinstallation logiciel' => 'Desinstallation',
//                            'Réinstallation logiciel' => 'Réinstallation',
//                        ],

                    ]
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
