<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\User;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=> 'name'])
            ->add('surname', TextType::class, ['label'=> 'surname'])
            ->add('username',TextType::class, ['label'=> 'username'],['attr' => ['maxlength' => 4]])
            ->add('email', TextType::class, ['label'=> 'email'])
            ->add('password', TextType::class, ['label'=> 'password'])
            ->add('phonenumber', TextType::class, ['label'=> 'phonenumber'])
        ;
    }
//curl -H "Content-Type: application/json" -d '{"name":"walter","surname":"white","username":"karthik","email":"walterwhite@gmail.com","password":"karthikb23"}' http://127.0.0.1:8000/api/register

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
