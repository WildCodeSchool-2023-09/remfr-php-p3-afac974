<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Artwork;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
            ])
            ->add('height', IntegerType::class, [
                'label' => 'Hauteur',
            ])
            ->add('width', IntegerType::class, [
                'label' => 'Largeur',
            ])
            ->add('isUnique', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Pièce unique',
            ])
            ->add('isSigned', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Signé',
            ])
            ->add('picture', TextType::class, [
                'label' => 'Nom de l\'oeuvre',
            ])
            ->add('pictureFile', VichFileType::class, [
                'required'      => true,
                'allow_delete'  => false,
                'download_uri' => false,
                'label' => 'Image de l\'oeuvre',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->queryFindAllArtist();
                },
                'choice_label' => function (User $user) {
                    return $user->getName() . ' ' . $user->getLastname();
                },
                'label' => 'Artiste',
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
