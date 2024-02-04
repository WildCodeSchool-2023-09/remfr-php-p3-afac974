<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class)
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
            'required' => false,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Répéter le mot de passe'],
            'constraints' => [new Assert\NotBlank(),
            new Assert\Regex([
                'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9])/',
                'message' => 'Le mot de passe doit contenir au moins une minuscule, 
                une majuscule, un chiffre et un caractère spécial.'
            ]),
            ],
        ])
        ->add('name', TextType::class, ['label' => 'Prénom'])
        ->add('lastname', TextType::class, ['label' => 'Nom de famille'])
        ->add('pseudonym', TextType::class, ['label' => 'Pseudonyme'])
        ->add('posterFile', VichFileType::class, [
            'label' => 'Photo de profil',
            'required'      => false,
            'allow_delete'  => true,
            'download_uri' => true,
            ])
        ->add('description', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
