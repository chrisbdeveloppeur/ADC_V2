<?php

namespace App\Form;

use App\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assetType', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Poste fixe' => 'demande',
                        'Poste portable' => 'incident',
                        'Ecran' => 'incident',
                        'Accessoires' => 'incident',
                        'Smartphone' => 'incident',
                        'Infra' => 'incident',
                        'Baie de brassage' => 'incident',
                    ]
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
