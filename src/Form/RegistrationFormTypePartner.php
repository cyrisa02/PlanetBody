<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormTypePartner extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Nom de la société',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
            ->add('contact', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Nom et prénom du gérant',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Rue',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Code Postal',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
            
            //  ->add('contact', EntityType::class, [
            //     'class' => Partner::class,
            //     'choice_label'=>function($contact){
            //     return $contact->getContact();
            // },
            // 'label' => 'Merci de choisir votre contact ',
            //     'attr' => [
            //         'class' => 'form-control '
            //     ],
            //     'placeholder'=>'Choisissez votre annonce dans la liste',

            // ])
             ->add('contract', TextType::class, [
                'mapped' => false,                
             ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Etes-vous d\'accord avec notre RGPD ?',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez être d\'accord avec nos conditions.',
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class' => 'form-control'                
            ],
             'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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