<?php

namespace App\Form;

use App\Entity\Asset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'required' => true,
                'choices' => [
                    'Poste fixe' => 'PCF',
                    'Laptop + avec ou sans d\'accueil' => 'LAP',
                    'Poste scientifique' => 'SCI',
                    ]
                ]
            )
            ->add('action', ChoiceType::class, [
//                'label' => false,
                'required' => true,
                'choices' => [
                    'Déménagement' => 'DEM_PDT',
                    'Prêt' => 'PRT',
                    'Nouvelle dotation sans reprise' => 'NDO',
                    'Reprise sans nouvelle dotation' => 'REP_PDT',
                    'Nouvelle dotation + reprise (renouvellement)' => 'REN',
                    ]
                ]

            )
            ->add('ae', TextType::class,[
//                    'label' => false,
                    'required' => true,
                ]
            )
            ->add('as', TextType::class,[
//                    'label' => false,
                    'required' => true,
                ]
            )
            ->add('rspd', CheckboxType::class,[
//                    'label' => false,
                    'required' => true,
                ]
            )
            ->add('tpx', IntegerType::class,[
//                'label' => false,
                'required' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Asset::class,
        ]);
    }
}
