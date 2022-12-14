<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('contact')
            ->add('contract', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '190',
                ],
                'label' => 'Type de contrat du franchisé, entrez le nom du contrat, suivi du nom du franchisé',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
                
            ])
             ->add('user',EntityType::class, [
                'required' => false,
                'class' => User::class,
                'choice_label'=>function($email){
                return $email->getEmail();
            },
            'label' => 'Merci de confirmer l\'adresse mail du franchisé. ',
                'attr' => [
                    'class' => 'form-control '
                ],
                'placeholder'=>'Choisissez votre email dans la liste',

            ])
            //->add('candidatures')
        
    
            //->add('name')
            //->add('city')
            //->add('contact')
            ->add('is_enable', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label' => 'Actif     ?    .',
                'label_attr' => [
                    'class' => 'form-check-label'
                ]
                
            ])
//->add('users')
            //->add('sporthalls')
           // ->add('permissions')
            //->add('mailings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}