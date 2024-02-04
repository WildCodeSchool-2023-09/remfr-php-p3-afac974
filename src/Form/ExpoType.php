<?php

namespace App\Form;

use App\Entity\Expo;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                    'label' => 'Nom de l\'exposition'
                ])
            ->add('description', TextType::class)
            ->add('location', TextType::class, [
                    'label' => 'Lieu de l\'exposition'
                ])
            ->add('dateEvent', DateTimeType::class, [
                    'label' => 'Date de l\'exposition',
                ])
            ->add('picture', TextType::class, [
                    'label' => 'Nom de l\'image de l\'exposition',
                ])
            ->add('pictureFile', VichFileType::class, [
                'label' => 'Image de l\'exposition',
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Artiste',
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->queryFindAllArtist();
                },
                'choice_label' => function (User $user) {
                    return $user->getName() . ' ' . $user->getLastname();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expo::class,
        ]);
    }
}
