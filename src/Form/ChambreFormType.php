<?php

namespace App\Form;

use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ChambreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du chambre'
            ])
            ->add('descriptionCourte', TextareaType::class, [
                'label' => 'Description courte de la chambre'
            ])
            ->add('descriptionLongue', TextareaType::class, [
                'label' =>  'Description longue de la chambre'
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'data_class' => null
            ])
            ->add('prixJournalier', TextType::class, [
                'label' => 'prix du chambre'
            ])
           ->add('submit', SubmitType::class, [
            'label' => "Ajouter",
            'validate' => false,
            'attr' => [
                'class' => "d-block mx-auto my-3 btn btn-success col-3"
            ],

           ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
            'allow_file_upload' => true,
            'photo' => null
        ]);
    }
}
