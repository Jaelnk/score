<?php

namespace App\Form;

use App\Entity\Tcatalogo;
use App\Entity\Tpersonainfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TpersonainfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $parameters = $options['parameters'];
        $idSelectProvincia = $options['idSelectProvincia'];
        $idSelectCanton = $options['idSelectCanton'];
        $idSelectParroquia = $options['idSelectParroquia'];

        $builder
            ->add('identificacion', TextType::class, array(
                'label' => 'Identificación',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 13, 'maxMessage' => '* Máximo 13 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.'])
                ],
                'attr' => array(
                    'class' => 'form-control  form-sm text-uppercase',
                    'maxlength' => 13,
                )
            ))
            ->add('nombres', TextType::class, array(
                'label' => 'Nombres',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 150, 'maxMessage' => '* Máximo 150 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.'])
                ],
                'attr' => array(
                    'class' => 'form-control  text-uppercase',
                    'maxlength' => 150,
                )
            ))
            ->add('apellidos', TextType::class, array(
                'label' => 'Apellidos',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 150, 'maxMessage' => '* Máximo 150 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.'])
                ],
                'attr' => array(
                    'class' => 'form-control  text-uppercase',
                    'maxlength' => 150,
                )
            ))
            ->add('correoPersonal', EmailType::class, array(
                'label' => 'Correo',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 200, 'maxMessage' => '* Máximo 200 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control ',
                    'maxlength' => 100,
                )
            ))
            ->add('direccion', CollectionType::class, [
                'entry_type' => TdireccionType::class,
                'entry_options' => [
                    'parameters' => $parameters,
                    'idSelectProvincia' => $idSelectProvincia,
                    'idSelectCanton' => $idSelectCanton,
                    'idSelectParroquia' => $idSelectParroquia,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('telefono', CollectionType::class, [
                'entry_type' => TtelefonoType::class,
                'entry_options' => [
                    'parameters' => $parameters,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('sumbmit', SubmitType::class, array(
                    'label' => 'Guardar',
                    'attr' => array(
                        'class' => 'btn btn-label-success    btn-next btn-submit',
                    )

                )
            );;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tpersonainfo::class,
        ])->setRequired(array(
            'parameters',
            'idSelectProvincia',
            'idSelectCanton',
            'idSelectParroquia',
        ));;
    }
}
