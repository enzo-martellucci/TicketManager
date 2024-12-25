<?php

namespace App\Form;

use App\Config\Priority;
use App\Config\Status;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTicketType extends AbstractType
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('assignedTo', ChoiceType::class, [
                'choices' => $this->userRepository->findUsersByRole('ROLE_SUPPORT'),
                'choice_value' => 'id',
                'choice_label' => function (?User $user) {
                    return $user->getEmail();
                },
                'placeholder' => 'Select a user',
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Status::OPEN->value => Status::OPEN,
                    Status::IN_PROGRESS->value => Status::IN_PROGRESS,
                    Status::RESOLVED->value => Status::RESOLVED,
                    Status::CLOSED->value => Status::CLOSED,
                ]
            ])
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    Priority::HIGH->value => Priority::HIGH,
                    Priority::MEDIUM->value => Priority::MEDIUM,
                    Priority::LOW->value => Priority::LOW,
                ]
            ])
            ->add('deadline')
            ->add('description')
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
