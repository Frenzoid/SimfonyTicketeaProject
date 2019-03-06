<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 10/02/18
 * Time: 16:50
 */

namespace App\Form;


use App\Entity\Categorias;
use App\Entity\Provincias;
use App\Entity\Eventos;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('enlaceExterno', TextType::class)
            ->add('direccion', TextType::class)
            ->add('fechaVentaInicio', DateType::class, ['widget' => 'single_text'])
            ->add('fechaVentaFinal', DateType::class,  ['widget' => 'single_text'])
            ->add('fechaEvento', DateType::class,  ['widget' => 'single_text'])
            ->add('numEntradasTot', NumberType::class)
            ->add('precio', NumberType::class)

            ->add(
                'poster',
                FileType:: class, array('data_class' => null)
               )
            ->add('provincia', EntityType::class, ['class' => Provincias::class])
            ->add('categoria', EntityType::class, ['class' => Categorias::class])
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
            'data_class' => Eventos::class,
        ));
    }
}