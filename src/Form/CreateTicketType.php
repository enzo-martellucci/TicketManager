<?php

namespace App\Form;

use App\Config\Priority;
use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    Priority::HIGH->value => Priority::HIGH,
                    Priority::MEDIUM->value => Priority::MEDIUM,
                    Priority::LOW->value => Priority::LOW,
                ]
            ])
            ->add('deadline')
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 8]
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
