<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rdv_total', NumberType::class, [
                    'required' => false,
                    'attr' =>['placeholder' => 'Nombre totale de rendez-vous programmés'],
                ]
            )
            ->add('rdv_ko_scc', NumberType::class, [
                    'required' => false,
                    'attr' =>['placeholder' => 'Nombre de rendez-vous annulé par SCC'],
                ]
            )
            ->add('rdv_ko_safran', NumberType::class, [
                    'required' => false,
                    'attr' =>['placeholder' => 'Nombre de rendez-vous annulé par SAFRAN'],
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
