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
            ->add('title', TextType::class)
            ->add('year', IntegerType::class)
            ->add('height', IntegerType::class)
            ->add('width', IntegerType::class)
            ->add('isUnique', ChoiceType::class, [
                'choices'  => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('isSigned', ChoiceType::class, [
                'choices'  => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('pictureFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
            ])
            ->add('artist', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->queryFindAllArtist();
                },
                'choice_label' => function (User $user) {
                    return $user->getName() . ' ' . $user->getLastname();
                },
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
