<?php

namespace App\Form;

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
            ->add('poste', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Poste fixe' => 'Desktop',
                        'Laptop + avec ou sans d\'accueil' => 'Laptop',
                        'Poste scientifique' => 'Ecran',
                    ]
                )
            )
            ->add('action', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Poste fixe' => 'Desktop',
                        'Laptop + avec ou sans d\'accueil' => 'Laptop',
                        'Poste scientifique' => 'Ecran',
                    ]
                )
            )
            ->add('ae', TextType::class,
                array('label' => false,
                    'required' => true,
                )
            )
            ->add('as', TextType::class,
                array('label' => false,
                    'required' => true,
                )
            )
            ->add('rspd', CheckboxType::class,
                array('label' => false,
                    'required' => true,
                )
            )
            ->add('tpx', IntegerType::class,
                array('label' => false,
                    'required' => true,
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
