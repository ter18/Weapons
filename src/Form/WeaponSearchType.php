<?php

namespace App\Form;

use App\Entity\WeaponSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchName', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => '兵器の名前'
                ]
            ])
            ->add('searchDate', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => '年(Ex: 2018)'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WeaponSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
    
    public function getBlockPrefix()
    {
        return '';
    }
}
