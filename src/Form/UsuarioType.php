<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 10/02/18
 * Time: 16:50
 */

namespace App\Form;


use App\Entity\Provincias;
use App\Entity\Roles;
use App\Entity\Usuarios;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('nombre', TextType::class)
            ->add('passwd', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('role', EntityType::class, ['class' => Roles::class])
            ->add(
                'avatar',
                FileType:: class, array('data_class' => null)
               )
            ->add('provincia', EntityType::class, ['class' => Provincias::class])
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Aplicar'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Usuarios::class,
        ));
    }
}