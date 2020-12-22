<?php

namespace App\Form;

use App\Entity\Asset;
use App\Entity\Survey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostnameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hostname = Asset::class;
        $builder
            ->add('newAsset', EntityType::class,[
                'class' => $hostname,
                'choice_label' => 'hostname',
                'label' => false,
                'required' => true,
                ]
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
