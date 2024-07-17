<?php

namespace App\Form;


use App\Entity\Tcatalogo;
use App\Entity\Tusuario;
use App\Service\Util\Catalogs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TusuarioType extends AbstractType
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $estadoActivoCat = $options['parameters']['P_CAT_ESTACTIVOCAT'];
        $catEstUser = Catalogs::ESTADO_USUARIO;
        $catRoles = Catalogs::ROLES_USUARIO;

        $builder
            ->add('nombreUsuario', TextType::class, array(
                'label' => 'Usuario',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 50, 'maxMessage' => '* Máximo 50 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.'])
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 50,
                )
            ))
            ->add('roles')
            ->add('roles', EntityType::class, array(
                'label' => 'Rol',
                'required' => true,
                'class' => Tcatalogo::class,
                'choice_label' => 'descObservaciones',
                'choice_value' => 'valorText',
                'query_builder' => function (EntityRepository $er) use ($options, $catRoles, $estadoActivoCat) {

                    return $er->getCatalogo($catRoles, $estadoActivoCat);
                },
                'attr' => array(
                    'class' => 'cmbrol form-control select2',
                )
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Password',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => '* Por favor ingrese la información solicitada.']),
                    new Length(['min' => 1, 'max' => 50, 'maxMessage' => '* Máximo 50 caracteres.', 'minMessage' => '* Mínimo 1 caracteres.'])
                ],
                'attr' => array(
                    'class' => 'form-control text-uppercase',
                    'maxlength' => 50,
                )
            ))
            ->add('idEstado', EntityType::class, array(
                'label' => 'Estado',
                'required' => true,
                'class' => 'App\Entity\Tcatalogo',
                'choice_label' => 'valorText',
                'choice_value' => 'idCatalogo',
                'query_builder' => function (EntityRepository $er) use ($options, $catEstUser, $estadoActivoCat) {
                    return $er->getCatalogo($catEstUser, $estadoActivoCat);
                },
                'attr' => array(
                    'class' => 'cmbrol form-control select2',
                )
            ));


        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) use ($catRoles, $estadoActivoCat) {
                    $array = null;
                    //Elimina el rol ROLE_USER si tiene mas roles
                    if ($tagsAsArray == null) {
                        return null;
                    }
                    foreach ($tagsAsArray as $r) {
                        if ($r != "ROLE_USER") {
                            $array[] = $r;
                        }
                    }
                    // Si solo tiene ROLE_USER lo reintegra
                    if ($array == null) {
                        $array[] = "ROLE_USER";
                    }
                    $repo = $this->em->getRepository(Tcatalogo::class)
                        ->getCatalogoRol($catRoles, $tagsAsArray[0], $estadoActivoCat);
                    return !empty($repo) ? $repo[0] : null;
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString->getValorText());
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tusuario::class,
        ])->setRequired(array(
            'parameters',
        ));
    }
}
