<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('demand', ChoiceType::class, [
                'choices' => [
                    'Retour sur l\'exposition' => 'retour_exposition',
                    'Demande de rôle artiste' => 'demande_role_artiste',
                    'Axe d\'amélioration' => 'axe_amelioration',
                    'Problème rencontré' => 'probleme_rencontre',
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
