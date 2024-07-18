<?php

namespace App\Form;

use App\Entity\Ttelefono;
use App\Entity\Tcatalogo;
use App\Service\Util\Catalogs;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TtelefonoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $estadoActivoCat = $options['parameters']['P_ESTADOCATALOGOACTIVO'];
        $catTipoTelefono = Catalogs::TIPO_TELEFONO;
        $builder
            ->add('idTipo', EntityType::class, array(
                'label' => 'Tipo Teléfono',
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                ],
                'class' => 'App\Entity\Tcatalogo',
                'choice_label' => 'valorText',
                'choice_value' => 'idCatalogo',
                'query_builder' => function (EntityRepository $er) use ($options, $catTipoTelefono, $estadoActivoCat) {
                    return $er->getCatalogo($catTipoTelefono, $estadoActivoCat);
                },
                'attr' => array(
                    'class' => 'form-control select2'
                )
            ))
            ->add('numero', TextType::class, array(
                'label' => 'Número',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 7, 'max' => 10, 'maxMessage' => '* Máximo 10 caracteres.', 'minMessage' => '* Mínimo 7 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 10,
                )
            ))
            ->add('extension', TextType::class, array(
                'label' => 'Extensión',
                'required' => false,
                'constraints' => [
                    new Length(['min' => 1, 'max' => 6, 'maxMessage' => '* Máximo 6 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 6,
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ttelefono::class,
        ])->setRequired(array(
            'parameters',
        ));;
    }
}
