<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
        ->add('title', TextType::class, $options, [
            'label' => 'Title',
            'constraints' => [
            new NotBlank([
                'message' => 'Title must exist.',
            ]),
            ]
        ])
        ->add('description', TextareaType::class, $options, [
            'label' => 'Description',
            'constraints' => [
            new NotBlank([
                'message' => 'Description must exist.',
            ]),
            ]
        ])
        ->add('dueDate', DateType::class, $options, [
            'constraints' => [
            new NotBlank([
                'message' => 'Date can not be blank.',
            ])
            ]
        ])
        ->add('status', ChoiceType::class, $options, [
            'choices' => [
                'Select Status' => 'select',
                'To do' => 'To Do',
                'Completed' => 'completed',
                'In progress' => 'In progress',
            ],
            'constraints' => [
            new NotBlank([
                'message' => 'Please enter a title for the task.',
            ]),
            ]
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults([
            'data_class' => Task::class,
        ]);
    }
}