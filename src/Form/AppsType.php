<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', ChoiceType::class, [
//                'label' => false,
                    'required' => false,
                    'placeholder' => 'Selectionner...',
                    'choices' => [
                        'Prêt' => 'PRT',
                        'Nouvelle dotation sans reprise' => 'NDO',
                        'Reprise sans nouvelle dotation' => 'REP',
                        'Nouvelle dotation + reprise (renouvellement)' => 'REN',
                    ]
                ]

            )
            ->add('asset', TextType::class,[
//                    'label' => false,
                    'required' => false,
                ]
            )
            ->add('rsdp', ChoiceType::class,[
//                'label' => false,
                    'required' => false,
                    'placeholder' => false,
                    'expanded' => true,
                    'choices' => [
                        'Oui' => 'oui',
                        'Non' => 'non',
                    ],
                    'data' => 'N/A',
                ]
            )
            ->add('tpx', IntegerType::class,[
//                'label' => false,
                    'required' => false,
                ]
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
