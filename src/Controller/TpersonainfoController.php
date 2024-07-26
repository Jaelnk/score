<?php

namespace App\Controller;

use App\Entity\Tdireccion;
use App\Entity\Tdpa;
use App\Entity\Tparametros;
use App\Entity\Tpersonadatos;
use App\Entity\Tpersonainfo;
use App\Entity\Ttelefono;
use App\Form\Tpersonainfo1Type;
use App\Form\TpersonainfoType;
use App\Form\TpersonaType;
use App\Repository\TparametrosRepository;
use App\Repository\TpersonadatosRepository;
use App\Repository\TpersonainfoRepository;
use App\Repository\TpersonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security as CoreSecurity;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[IsGranted('ROLE_USER')]
class TpersonainfoController extends AbstractController
{

    #solicitudes
    /* public function indexsoli(TpersonadatosRepository $tpersonadatosRepository): Response
    {
        return $this->render('solicitud/index.html.twig', [
            'tpersonainfos' => $tpersonadatosRepository->findAll(),
        ]);
    } */
    private $httpClient;
    private $logger;
    private $security;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger, CoreSecurity $security)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->security = $security;
    }

    public function indexsoli(Request $request, TpersonainfoRepository $tpersonainfoRepository): Response
    {
        $ipAddress = $request->headers->get('x-forwarded-for');

        $user = $this->security->getUser();
        if ($user){
            $username = $user->getUserIdentifier();
            $userMethods = get_class_methods($user);
        }

        dump($ipAddress);
        dump($userMethods);

        //si identificacion ==null , intentificacion = ' '
        $identificacion = $request->query->get('identificacion', ' ');
        
        dump($identificacion);
        $apiData = [];
        if ($identificacion != ' ') {
            try {
                $response = $this->httpClient->request('POST', 'https://172.16.1.236:8443/api/listado/personas', [
                    'json' => [
                        'identificacion' => $identificacion,
                        'usuario' => [
                            'usuario' => $username,
                            'ip' => ' ',
                            'rol' => ' '
                        ]
                    ],
                    'verify_peer' => false, 
                    'verify_host' => false, 
                ]);

                $apiData = $response->toArray();
                dump("*********************************************");
                dump($apiData['ListadoPersonas']);

            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al obtener los datos: ' . $e->getMessage());
            }
        }else{
            $apiData = [
                "ListadoPersonas" => [],
                "CodigoResultado" => "000",
                "Mensaje" => "TRANSACCION REALIZADA CORRECTAMENTE"
            ];
        }

        
        
        return $this->render('solicitud/index.html.twig', [
            'tpersonainfos' => $apiData['ListadoPersonas'],
            
            //'apiData' => $apiData['ListadoPersonas'],
        ]);
    }
    
    #new user soli
     public function newUser(Request $request): Response
    {

        $persona = new Tpersonadatos;
        $form = $this->createFormBuilder($persona) #task
            ->add('IDENTIFICACION', TextType::class, ['label'=>'identificación'])
            ->add('NOMBRES', TextType::class, ['label' => 'Nombre',])
            ->add('APELLIDOS', TextType::class, ['label' => 'Apellidos',])
            ->add('CORREO_PERSONAL', TextType::class, ['label' => 'Correo',])
            ->add('save', SubmitType::class)
            ->getForm();
       
     
        $form->handleRequest($request);

        $campos = $form->getData();
                //print_r($campos);
        #echo "Nombre: ".$campos->getIdentificacion " | E-Mail: ".$campos->getCorreo()." | Teléfono: ".$campos->getTelefono();
   
    
        return $this->render('solicitud/new.html.twig', [ 'form' => $form->createView(),]);
    }

    #locations list
    public function getlocation(Request $request, TpersonainfoRepository $tpersonainfoRepository): Response
    {
        $user = $this->security->getUser();
        if ($user){
            $username = $user->getUserIdentifier();
            #$userMethods = get_class_methods($user);
        }

        
        $cpersona = $request->query->get('CPersona', ' ');
        dump($cpersona);

        $apiData = [];
        if ($cpersona) {
            try {
                $response = $this->httpClient->request('POST', 'https://172.16.1.236:8443/api/listado/ubicaciones', [
                    'json' => [
                        'cpersona' => $cpersona,
                        'usuario' => [
                            'usuario' => $username,
                            'ip' => ' ',
                            'rol' => ' '
                        ]
                    ],
                    'verify_peer' => false, 
                    'verify_host' => false,
                ]);

                $apiData = $response->toArray();
                dump("*********************************************");
                dump($apiData['ListadoUbicaciones']);

            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al obtener los datos: ' . $e->getMessage());
            }
        }


        return $this->render('solicitud/indexdomic.html.twig', [
            'domicilios' => $apiData['ListadoUbicaciones']
        ]);
    }

    #editlocation
    public function editlocation(Request $request, EntityManagerInterface $entityManager, TparametrosRepository $parametrosRepo, TpersonaRepository $repoper): Response
    {

        $formData = $request->request->all();
        $currentDateTime = new \DateTime();
        $formattedDate = $currentDateTime->format('Y-m-d\TH:i:s');

        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');
        
        $user = $this->security->getUser();
        if ($user){
            $username = $user->getUserIdentifier();
            #$userMethods = get_class_methods($user);
        }

        dump($formattedDate);

        



        $descripcion = $request->request->get('descripcion');
        $Direccion = $request->request->get('Direccion');
        $numeroubicacion = $request->request->get('numeroubicacion');
        $CPersona = $request->request->get('CPersona');
        $Pais = $request->request->get('Pais');
        $DescripcionPais = $request->request->get('DescripcionPais');
        $Provincia = $request->request->get('Provincia');
        $NombreProvincia = $request->request->get('NombreProvincia');
        $NombreCanton = $request->request->get('NombreCanton');
        $CCanton = $request->request->get('CCanton');
        $CParroquia = $request->request->get('CParroquia');
        $NombreParroquia = $request->request->get('NombreParroquia');
        $Observaciones = $request->request->get('Observaciones');
        $Sector = $request->request->get('Sector');
        $NombrePropietario = $request->request->get('NombrePropietario');
        $CodigoZip5 = $request->request->get('CodigoZip5');
        $FechaIngresoResidencia = $request->request->get('FechaIngresoResidencia');
        $Urbanizacion = $request->request->get('Urbanizacion');
        $tipositiodes = $request->request->get('tipositiodes');
        $LatitudGPS = $request->request->get('LatitudGPS');
        $LongitudGPS = $request->request->get('LongitudGPS');
        $cUsuarioGeoref = $request->request->get('cUsuarioGeoref');
        $fUltimaGeor = $request->request->get('fUltimaGeor');

        $latitude_value = 'default_value';
        dump($CPersona);


        // Create the form
        $form = $this->createFormBuilder()
            ->add('Pais', TextType::class, [
                'label' => 'Pais',
                'data' => $DescripcionPais,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('Provincia', TextType::class, [
                'label' => 'Provincia',
                'data' => $NombreProvincia,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('Canton', TextType::class, [
                'label' => 'Cantón',
                'data' => $NombreCanton,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('Parroquia', TextType::class, [
                'label' => 'Parroquia',
                'data' => $NombreParroquia,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('TipoDir', TextType::class, [
                'label' => 'Tipo',
                'data' => $descripcion,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('Direccion', TextType::class, [
                'label' => 'Direccion',
                'data' => $Direccion,
                'required' => false,
            ])
            ->add('Urbanizacion', TextType::class, [
                'label' => 'Urbanizacion',
                'data' => $Urbanizacion,
                'required' => false,
            ])
            ->add('Observaciones', TextType::class, [
                'label' => 'Observaciones',
                'data' => $Observaciones,
                'required' => false,
            ])
            ->add('Referencia', TextType::class, [
                'label' => 'Referencia',
                'data' => $Sector,
                'required' => false,
            ])
            ->add('Sector', TextType::class, [
                'label' => 'Sector',
                'data' => $tipositiodes,
                'required' => false,
            ])
            ->add('NombrePropet', TextType::class, [
                'label' => 'Nombre Propietario',
                'data' => $NombrePropietario,
                'required' => false,
            ])
            ->add('ZonaPost', TextType::class, [
                'label' => 'Zona Postal',
                'data' => $CodigoZip5,
                'required' => false,
            ])
            ->add('FIngresoRef', TextType::class, [
                'label' => 'Fecha Ingreso Referencia',
                'data' => $FechaIngresoResidencia,
                'required' => false,
            ])

            ->add('cUsuarioGeoref', TextType::class, [
                'label' => 'Usuario ultima modificación',
                'data' => $cUsuarioGeoref,
                'required' => false,
                'attr' => ['readonly' => true],
            ])
            ->add('fUltimaGeor', TextType::class, [
                'label' => 'Fecha Ultima Georeferenciación',
                'data' => $fUltimaGeor,
                'required' => false,
                'attr' => ['readonly' => true],
            ])
            /* ->add('Latitud', TextType::class, [
                'label' => 'Latitud',
                'data' => $LatitudGPS,
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('Longitud', TextType::class, [
                'label' => 'Longitud',
                'data' => $LongitudGPS,
                'attr' => ['readonly' => true],
                'required' => false,
            ]) */
            #CORDENADAS
            ->add('LongitudGPS', HiddenType::class, [
                'data' => $LongitudGPS,
            ])
            ->add('LatitudGPS', HiddenType::class, [
                'data' => $LatitudGPS,
            ])
            #CORDENADAS-¨

            ->add('Cpersona', HiddenType::class, [
                'data' => $CPersona,
            ])
            ->add('numeroubicacion', HiddenType::class, [
                'data' => $numeroubicacion,
            ])
            ->add('cusuario', HiddenType::class, [
                'data' => $username,
            ])
            ->add('formattedDate', HiddenType::class, [
                'data' => $formattedDate,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
            ])
            ->getForm();
        
            $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $data['cUsuarioGeoref'] = $username;

            $latitude = $request->request->get('latitude');
            $longitude = $request->request->get('longitude');

            #api
            $numeroubicacion =  $data['numeroubicacion'];
            $Cpersona =  $data['Cpersona'];
            $Direccion =  $data['Direccion'];
            #envio de campos de formulario

            

            try {
                $response = $this->httpClient->request('POST', 'https://172.16.1.236:8443/api/listado/guardarubicaciones', [
                    'json' => [
                        'cpersona' => $Cpersona,
                        "numerodireccion" => $numeroubicacion,
                        "latitudGps"=> $latitude,
                        "longitudGps"=> $longitude,
                        "cUsuarioGeoref" => $username,
                        "fUltimaGeor" => $formattedDate,
                        'usuario' => [
                            'usuario' => $username,
                            'ip' => ' ',
                            'rol' => ' '
                        ]
                    ],
                    'verify_peer' => false, 
                    'verify_host' => false, 
                ]);

                if($response->getStatusCode() === 200){
                    $this->addFlash('success', 'TRANSACCION REALIZADA CORRECTAMENTE');
                
                }
                if($response->getStatusCode() === 500){
                    $this->addFlash('error', 'ERROR AL CONECTAR CON FITBANK, INTENTE DE NUEVO');
                }
                

    
                $apiData = $response->toArray();
                
            } catch (\Exception $e) {
                dump('Error al obtener los datos: ' . $e->getMessage());
            }

            return $this->render('solicitud/updatedireccion.html.twig', [
                'form' => $form->createView(),
                'CPersona' => $CPersona,
                'username' => $username
            ]);

        }

        return $this->render('solicitud/updatedireccion.html.twig', [
            'form' => $form->createView(),
            'CPersona' => $CPersona,
            'username' => $username
        ]);

        /* return $this->redirectToRoute('domicilio_edit', 
            [
            'Direccion' => $Direccion ,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'cpersona' => $CPersona,
            'numeroubicacion' => $numeroubicacion

        ]); */


        /* $parameters = $parametrosRepo->getAllParameter();
        $tpersonainfo = new Tpersonainfo();
        $tdireccion = new Tdireccion();
        $tpersonainfo->addDireccion($tdireccion);
        //Parametros para SgaDireccionType
        $idSelectProvincia = isset($request->get('tpersonainfo')['direccion'][0]['idProvincia']) ? $request->get('tpersonainfo')['direccion'][0]['idProvincia'] : 17;
        $idSelectCanton = isset($request->get('tpersonainfo')['direccion'][0]['idCanton']) ? $request->get('tpersonainfo')['direccion'][0]['idCanton'] : 1701;
        $idSelectParroquia = isset($request->get('tpersonainfo')['direccion'][0]['idParroquia']) ? $request->get('tpersonainfo')['direccion'][0]['idParroquia'] : 0;

        $form = $this->createForm(TpersonainfoType::class, $tpersonainfo, [
            'parameters' => $parameters,
            'idSelectProvincia' => $idSelectProvincia,
            'idSelectCanton' => $idSelectCanton,
            'idSelectParroquia' => $idSelectParroquia,
        ]);
        $form->handleRequest($request); */

/* -- */
       /*  $persona = new Tpersonainfo;
        $form = $this->createFormBuilder($persona) #task
            ->add('nombres', TextType::class, [
                'label' => 'Nombres',
                'required' => false,
            ])
            ->add('apellidos', TextType::class, [
                'label' => 'Apellidos',
                'required' => false,
            ])
            ->add('identificacion', TextType::class, [
                'label' => 'Identificación',
                'required' => false,
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => 'Sexo',
                'choices' => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                    'Otro' => 'O',
                ],
                'required' => false,
            ])
            ->add('correoTrabajo', TextType::class, [
                'label' => 'Correo de Trabajo',
                'required' => false,
            ])
            ->add('correoPersonal', TextType::class, [
                'label' => 'Correo Personal',
                'required' => false,
            ])
            ->add('idTipoIdentificacion', TextType::class, [
                'label' => 'Tipo de Identificación',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Guardar'
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $submittedToken=$request->request->get('token');
        $form->handleRequest($request);

        if($form -> isSubmitted()){

            if($this->isCsrfTokenValid('generico', $submittedToken))
            {
                $campos = $form->getData();
                //print_r($campos);
                //echo "Nombre: ".$campos->getNombre()." | E-Mail: ".$campos->getCorreo()." | Teléfono: ".$campos->getTelefono();
                die();
            }else
            {
                #die("error del token");
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error inesperado');
                return $this->redirectToRoute('formularios_simple');
            }

            $campos = $form-> getData();
            print_r($campos);
            die();
        }

        return $this->render('solicitud/updatedireccion.html.twig', [ 'form' => $form->createView(),]); */
    }

    



    #[Route('/tpersonainfo', name: 'app_tpersonainfo_index')]
    public function index(TpersonainfoRepository $tpersonainfoRepository): Response
    {
        return $this->render('tpersonainfo/index.html.twig', [
            'tpersonainfos' => $tpersonainfoRepository->findAll(),
        ]);
    }

    public function new(Request $request, EntityManagerInterface $entityManager, TparametrosRepository $parametrosRepo, TpersonaRepository $repoper): Response
    {
        $parameters = $parametrosRepo->getAllParameter();
        $tpersonainfo = new Tpersonainfo();
        $tdireccion = new Tdireccion();
        $telefono1 = new Ttelefono();
        $telefono2 = new Ttelefono();
        $tpersonainfo->addDireccion($tdireccion);
        $tpersonainfo->addTelefono($telefono1);
        $tpersonainfo->addTelefono($telefono2);
        //Parametros para SgaDireccionType
        $idSelectProvincia = isset($request->get('tpersonainfo')['direccion'][0]['idProvincia']) ? $request->get('tpersonainfo')['direccion'][0]['idProvincia'] : 17;
        $idSelectCanton = isset($request->get('tpersonainfo')['direccion'][0]['idCanton']) ? $request->get('tpersonainfo')['direccion'][0]['idCanton'] : 1701;
        $idSelectParroquia = isset($request->get('tpersonainfo')['direccion'][0]['idParroquia']) ? $request->get('tpersonainfo')['direccion'][0]['idParroquia'] : 0;

        $form = $this->createForm(TpersonainfoType::class, $tpersonainfo, [
            'parameters' => $parameters,
            'idSelectProvincia' => $idSelectProvincia,
            'idSelectCanton' => $idSelectCanton,
            'idSelectParroquia' => $idSelectParroquia,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($tpersonainfo);
            $entityManager->flush();


            return $this->redirectToRoute('app_tpersonainfo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tpersonainfo/new.html.twig', [
            'tpersona' => $tpersonainfo,
            'form' => $form,
        ]);
    }


    public function show(Tpersonainfo $tpersonainfo): Response
    {
        return $this->render('tpersonainfo/show.html.twig', [
            'tpersonainfo' => $tpersonainfo,
        ]);
    }

    public function edit(Request $request, Tpersonainfo $tpersonainfo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Tpersonainfo1Type::class, $tpersonainfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tpersonainfo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tpersonainfo/edit.html.twig', [
            'tpersonainfo' => $tpersonainfo,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, Tpersonainfo $tpersonainfo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tpersonainfo->getIdPersona(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tpersonainfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tpersonainfo_index', [], Response::HTTP_SEE_OTHER);
    }

    public function cargaComboCanton(Request $request, EntityManagerInterface $em): Response
    {
        $idProvincia = trim($request->get('idProvincia'));
        $objEst = $em->getRepository(Tparametros::class)->findOneBy(["idParametro" => 'P_ESTADOACTIVODPA']);
        $cantones = $em->getRepository(Tdpa::class)->findBy(array("idDpaPadre" => $idProvincia, "idEstado" => $objEst->getValorNum()));
        return $this->render('tpersona/list_caton.html.twig', array(
            "cantones" => $cantones
        ));
    }

    public function cargaComboParroquia(Request $request, ManagerRegistry $doctrin): Response
    {
        $idCanton = trim($request->get('idCanton'));


        $em = $doctrin->getManager();
        $objEst = $em->getRepository(Tparametros::class)->findOneBy(["idParametro" => 'P_ESTADOACTIVODPA']);
        $repoParroquia = $em->getRepository(Tdpa::class);
        $queryParroquia = $repoParroquia->createQueryBuilder('pr')
            ->where('pr.idDpaPadre = :idDpaPadre')
            ->andWhere('pr.idEstado = :estado')
            ->setParameter('idDpaPadre', $idCanton)
            ->setParameter('estado', $objEst->getValorNum())
            ->addOrderBy('pr.nombre');
        $queryParroquia = $queryParroquia->getQuery();
        $parroquias = $queryParroquia->getResult();

        return $this->render('tpersona/list_parish.html.twig', array(
            "parroquias" => $parroquias
        ));
    }
}
