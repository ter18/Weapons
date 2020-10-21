<?php

namespace App\Form;

use App\Entity\Options;
use App\Entity\Weapon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('created_at', DateType::class, ['format' => 'd-MM-yyyy', 'years' => range('1950', '2020')])
            ->add('power', ChoiceType::class, ['choices' => array_flip(Weapon::POWER)])
            ->add('description')
            ->add('my_file', FileType::class, [
                'mapped' => false,
                'label' => 'Charger un fichier',
                'required' => false,
            ])
            ->add('options', EntityType::class,[
                'class' => Options::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Weapon::class,
            'translation_domain' => 'forms'
        ]);
    }
}
