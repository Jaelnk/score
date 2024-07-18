<?php

namespace App\Form;

use App\Entity\Tdireccion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TdireccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $estadoADM = $options['parameters']['P_ESTADOACTIVODPA'];
        $tipoProvinciaDPA = $options['parameters']['P_TIPOPROVINCIADPA'];
        $idSelectProvincia = $options['idSelectProvincia'];
        $idSelectCanton = $options['idSelectCanton'];
        $idSelectParroquia = $options['idSelectParroquia'];


        $builder
            ->add('idProvincia', EntityType::class, array(
                'label' => 'Provincia',
                'required' => true,
                'class' => 'App\Entity\Tdpa',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione la Provincia',
                'query_builder' => function (EntityRepository $er) use ($options, $estadoADM, $tipoProvinciaDPA) {
                    return $er->createQueryBuilder('tp')
                        ->where('tp.idTipo = :tipo')
                        ->andWhere('tp.idEstado = :estado')
                        ->setParameter('tipo', $tipoProvinciaDPA)
                        ->setParameter('estado', $estadoADM);
                },
                'attr' => array(
                    'class' => 'cmbProvincia form-control select2'
                )
            ))
            ->add('idCanton', EntityType::class, array(
                'label' => 'Cantón',
                'required' => true,
                'class' => 'App\Entity\Tdpa',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione el Cantón',
                'query_builder' => function (EntityRepository $er) use ($options, $idSelectProvincia, $estadoADM) {
                    return $er->createQueryBuilder('tc')
                        ->where('tc.idDpaPadre = :idprovincia')
                        ->andWhere('tc.idEstado = :estado')
                        ->setParameter('idprovincia', $idSelectProvincia == '' ? 0 : $idSelectProvincia)
                        ->setParameter('estado', $estadoADM);
                },
                'attr' => array(
                    'class' => 'cmbCanton form-control select2'
                )
            ))
            ->add('idParroquia', EntityType::class, array(
                'label' => 'Parroquia',
                'required' => true,
                'class' => 'App\Entity\Tdpa',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione la Parroquia',
                'query_builder' => function (EntityRepository $er) use ($options, $idSelectCanton, $estadoADM) {
                    return $er->createQueryBuilder('tc')
                        ->where('tc.idDpaPadre = :idCanton')
                        ->andWhere('tc.idEstado = :estado')
                        ->setParameter('idCanton', $idSelectCanton == '' ? 0 : $idSelectCanton)
                        ->setParameter('estado', $estadoADM);
                },
                'attr' => array(
                    'class' => 'cmbParroquia form-control select2'
                )
            ))
            ->add('callePrincipal', TextType::class, array(
                'label' => 'Calle Principal',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 50, 'maxMessage' => '* Máximo 50 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 50,
                )
            ))
            ->add('numeroDomicilio', TextType::class, array(
                'label' => 'Num. Domicilio',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 8, 'maxMessage' => '* Máximo 8 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 8,
                )
            ))
            ->add('calleSecundaria', TextType::class, array(
                'label' => 'Calle Secundaria',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 50, 'maxMessage' => '* Máximo 50 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 50,
                )
            ))
            ->add('referencia', TextType::class, array(
                'label' => 'Referencia Domicilio',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 80, 'maxMessage' => '* Máximo 50 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.']),
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 80,
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tdireccion::class,
        ])->setRequired(array(
            'parameters',
            'idSelectProvincia',
            'idSelectCanton',
            'idSelectParroquia',
        ));
    }
}
