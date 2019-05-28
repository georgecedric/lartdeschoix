<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',  TextType::class, [
                'attr' => [
                    'placeholder' => "Veuillez entrer votre nom d'utilisateur"],
                    'label' => "votre Pseudo"    
                    ])
            ->add('email',  EmailType::class, [
                'attr' => [
                     'placeholder' => "Veuillez entrer votre email"],
                     'label' => "votre email"    
                     ])
            
            ->add('password', PasswordType::class, [
                'attr' => [
                     'placeholder' => "Veuillez entrer votre mot de passe"],
                     'label' => "votre mot de passe"    
                     ])
            ->add('confirm_password', PasswordType::class, [
                'attr' => [
                     'placeholder' => "Veuillez entrer une nouvelle fois votre mot de passe"],
                     'label' => "confirmez votre mot de passe"    
                     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
