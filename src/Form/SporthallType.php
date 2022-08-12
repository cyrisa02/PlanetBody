<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Sporthall;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SporthallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('contact')
            ->add('user',EntityType::class, [
                'required' => false,
                'class' => User::class,
                'choice_label'=>function($email){
                return $email->getEmail();
            },
            'label' => 'Merci de confirmer l\'adresse mail de la salle de sport. ',
                'attr' => [
                    'class' => 'form-control '
                ],
                'placeholder'=>'Choisissez votre email dans la liste',

            ])
            ->add('isEnable', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label' => 'Actif     ?    .',
                'label_attr' => [
                    'class' => 'form-check-label'
                ]
                
            ])
            //->add('permissions')
            //->add('mailings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sporthall::class,
        ]);
    }
}