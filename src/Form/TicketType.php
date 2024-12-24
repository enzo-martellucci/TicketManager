<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Config\Priority;
use App\Config\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-textarea'],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => array_combine(
                    array_map(fn(Status $status) => $status->value, Status::cases()),
                    Status::cases()
                ),
                'attr' => ['class' => 'form-select'],
            ])
            ->add('priority', ChoiceType::class, [
                'label' => 'Priority',
                'choices' => array_combine(
                    array_map(fn(Priority $priority) => $priority->value, Priority::cases()),
                    Priority::cases()
                ),
                'attr' => ['class' => 'form-select'],
            ])
            ->add('deadline', DateTimeType::class, [
                'label' => 'Deadline',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
