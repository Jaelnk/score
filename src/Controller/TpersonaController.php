<?php

namespace App\Controller;

use App\Entity\Tdpa;
use App\Entity\Tparametros;
use App\Entity\Tpersona;
use App\Entity\Tdireccion;
use App\Entity\Ttelefono;
use App\Form\TpersonaType;
use App\Repository\TparametrosRepository;
use App\Repository\TpersonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TpersonaController extends AbstractController
{

    public function index(TpersonaRepository $tpersonaRepository): Response
    {
        return $this->render('tpersona/index.html.twig', [
            'tpersonas' => $tpersonaRepository->findAll(),
        ]);
    }


    public function new(Request $request, EntityManagerInterface $entityManager, TparametrosRepository $parametrosRepo, TpersonaRepository $repoper): Response
    {
        $parameters = $parametrosRepo->getAllParameter();

        $tpersona = new Tpersona();
        $tdireccion = new Tdireccion();
        $telefono1 = new Ttelefono();
        $telefono2 = new Ttelefono();
        $tpersona->addDireccion($tdireccion);
        $tpersona->addTelefono($telefono1);
        $tpersona->addTelefono($telefono2);
        //Parametros para SgaDireccionType
        $idSelectProvincia = isset($request->get('tpersona')['direccion'][0]['idProvincia']) ? $request->get('tpersona')['direccion'][0]['idProvincia'] : 17;
        $idSelectCanton = isset($request->get('tpersona')['direccion'][0]['idCanton']) ? $request->get('tpersona')['direccion'][0]['idCanton'] : 1701;
        $idSelectParroquia = isset($request->get('tpersona')['direccion'][0]['idParroquia']) ? $request->get('tpersona')['direccion'][0]['idParroquia'] : 0;


        $form = $this->createForm(TpersonaType::class, $tpersona, [
            'parameters' => $parameters,
            'idSelectProvincia' => $idSelectProvincia,
            'idSelectCanton' => $idSelectCanton,
            'idSelectParroquia' => $idSelectParroquia,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($tpersona);
            $entityManager->flush();


            return $this->redirectToRoute('app_tpersona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tpersona/new.html.twig', [
            'tpersona' => $tpersona,
            'form' => $form,
        ]);
    }


    public function show(Tpersona $tpersona): Response
    {
        return $this->render('tpersona/show.html.twig', [
            'tpersona' => $tpersona,
        ]);
    }


    public function edit(Request $request, Tpersona $tpersona, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TpersonaType::class, $tpersona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tpersona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tpersona/edit.html.twig', [
            'tpersona' => $tpersona,
            'form' => $form,
        ]);
    }


    public function delete(Request $request, Tpersona $tpersona, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tpersona->getIdPersona(), $request->request->get('_token'))) {
            $entityManager->remove($tpersona);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tpersona_index', [], Response::HTTP_SEE_OTHER);
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
