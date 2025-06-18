<?php
namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\BookStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Auteurs',
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
            ])
            ->add('cover', TextType::class, [
                'label' => 'Couverture',
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name',
                'label' => 'Éditeur',
            ])
            ->add('editedAt', DateTimeType::class, [
                'label' => 'Date d\'édition',
                'widget' => 'single_text',
            ])
            ->add('plot', TextareaType::class, [
                'label' => 'Résumé',
            ])
            ->add('pageNumber', IntegerType::class, [
                'label' => 'Nombre de pages',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => BookStatus::AVAILABLE,
                    'Emprunté' => BookStatus::BORROWED,
                    'Réservé' => BookStatus::RESERVED,
                    'Perdu' => BookStatus::LOST,
                ],
                'choice_label' => function ($choice, $key, $value) { return $key; },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
} 