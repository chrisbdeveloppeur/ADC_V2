<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
//                'label' => false,
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'Poste fixe' => 'PCF',
                    'Laptop + avec ou sans d\'accueil' => 'LAP',
                    'Poste scientifique' => 'SCI',
                    ]
                ]
            )
            ->add('action', ChoiceType::class, [
//                'label' => false,
                'required' => false,
                'placeholder' => false,
                'choices' => [
                    'Déménagement' => 'DEM',
                    'Prêt' => 'PRT',
                    'Nouvelle dotation sans reprise' => 'NDO',
                    'Reprise sans nouvelle dotation' => 'REP',
                    'Nouvelle dotation + reprise (renouvellement)' => 'REN',
                    ]
                ]

            )
            ->add('ae', TextType::class,[
//                    'label' => false,
                    'required' => false,
                ]
            )
            ->add('as', TextType::class,[
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
                        'Sans RDV' => 'N/A',
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
//            'data_class' => Asset::class,
        ]);
    }
}
