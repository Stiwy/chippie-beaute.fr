<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom',
                    'class' => 'custom-input'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom',
                    'class' => 'custom-input'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 55
                    ]),
                    new Email()
                ],

                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email',
                    'class' => 'custom-input'
                ]
            ])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'custom-input'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je déclare avoir été familiarisé avec les Principes de traitement des données personnelles et avec les conditions générales de vente.',
                'label_attr' => [
                    'class' => 'text-gray-500 text-sm'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Je déclare avoir été familiarisé avec les Principes de traitement des données personnelles et avec les conditions générales de vente.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'label' => 'Votre mot de passe',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'custom-label'
                    ],
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe.',
                        'class' => 'custom-input'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir votre mot de passe.',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} characters',
                            'max' => 4096,
                        ]),
                        new Regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_\/])([-+!*$@%_\w\/]{8,25})$/', 'Votre mot de passe doit contenir au moins, 1 majuscule, 1 miniscule, 1 chiffre, 1 caractère spécial (-+!*$@%_/)')
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'label_attr' => [
                        'class' => 'custom-label'
                    ],
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe.',
                        'class' => 'custom-input'
                    ]
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                    'placeholder' => 'Merci de saisir votre numéro de téléphone',
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                    'placeholder' => 'Merci de saisir votre adresse',
                ]
            ])
            ->add('address_complement', TextType::class, [
                'label' => 'Complément d\'adresse',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                    'placeholder' => 'Merci de saisir votre complément d\'adresse',
                ]
            ])
            ->add('zip_code', IntegerType::class, [
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                    'placeholder' => 'Merci de saisir votre code postal',
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                    'placeholder' => 'Merci de saisir votre ville',
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'data' => 'FR',
                'label_attr' => [
                    'class' => 'custom-label'
                ],
                'attr' => [
                    'class' => 'custom-input',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer mon compte',
                'attr' => [
                    'class' => 'mt-5 w-full bg-black text-white h-12 border-2 border-black hover:bg-white hover:text-black'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
