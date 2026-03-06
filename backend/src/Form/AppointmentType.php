<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Owner;
use App\Entity\Pet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('description')
            ->add('pet', EntityType::class, [
                'class' => Pet::class,
                'choice_label' => 'id',
            ])
            ->add('owner', EntityType::class, [
                'class' => Owner::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
