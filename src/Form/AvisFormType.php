<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
        ])
        ->add('pseudo', TextType::class, [
            'label' => 'Pseudo',
        ])
        ->add('category', ChoiceType::class, [
            'label' => 'Catégories',
            'choices' => [
                'Chambre' => 'Chambre',
                'Restaurant' => 'Restaurant',
                'Soin' => 'Soin',
                'General' => 'Général',
            ]
        ])
        ->add('email', TextType::class, [
            'label' => 'Email',
        ])
        ->add('comment', TextareaType::class, [
            'label' => 'Votre Avis',
            'attr' => [
                'placeholder' => "Laisser votre avis ici",
                'class' => 'editor' # cette classe nous permet d'activer CkEditor
            ],
            'constraints' => [
                new NotBlank(),
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Commenter <i class='bi bi-send'></i>",
            'label_html' => true, # Permet d'interpréter le HTML dans le label
            'validate' => false,
            'attr' => [
                'class' => 'd-block mx-auto my-4 w-100 btn btn-outline-secondary'
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
