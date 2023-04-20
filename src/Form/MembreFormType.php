<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MembreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Inscrire un email",
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer une adresse email.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => "L'adresse email ne peut pas dépasser {{ limit }} caractères.",
                        'min' => 4,
                        'minMessage' => "L'adresse email doit contenir au moins {{ limit }} caractères.",
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => "Créer votre mot de passe",
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez créer un mot de passe.']),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'max' => 255,
                        'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prénom"
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom"
            ])
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                    'Apache' => 'apache'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez indiquer votre sexe"
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer membre",
                'validate' => false,
                'attr' => [
                    'class' => "d-block mx-auto my-3 col-4 btn btn-lg btn-outline-success"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
