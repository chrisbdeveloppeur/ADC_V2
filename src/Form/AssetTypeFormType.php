<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetType', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Poste fixe' => 'Desktop',
                        'Poste portable' => 'Laptop',
                        'Ecran' => 'Ecran',
                        'Accessoires' => 'Accessoire',
                        'Smartphone' => 'Smartphone',
                        'Infra / Prise réseau' => 'Infra-Réseau',
                        'Baie de brassage' => 'Baie-de-brassage',
                        'Autre' => 'Autre',
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
