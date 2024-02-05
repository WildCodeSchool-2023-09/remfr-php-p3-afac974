<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', TextType::class)
            ->add('pseudonym', TextType::class, [
                'label' => 'Pseudonyme',
            ])
            ->add('description', TextareaType::class)
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => false,
                'label' => 'photo de profil',
                ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Artist' => 'ROLE_ARTIST',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
