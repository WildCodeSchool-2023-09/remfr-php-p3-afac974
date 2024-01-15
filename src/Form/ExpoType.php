<?php

namespace App\Form;

use App\Entity\Expo;
use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'label' => 'Nom de l\'expo'
                ]
            ])
            ->add('location')
            ->add('dateEvent');
        // ->add('artist', EntityType::class, [
        //  'class' => Artist::class,
        //   'choice_label' => 'name'
        //  ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expo::class,
        ]);
    }
}
