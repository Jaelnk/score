<?php

namespace App\Controller;

use App\Entity\Tparametros;
use App\Entity\Tusuario;
use App\Form\TusuarioType;
use App\Repository\TusuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TusuarioController extends AbstractController
{
    public function index(TusuarioRepository $tpersonaRepository): Response
    {
        return $this->render('tusuario/login.html.twig', [
            'tusuarios' => $tpersonaRepository->findAll(),
        ]);
    }

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parametrosRepo = $entityManager->getRepository(Tparametros::class);
        $parameters = $parametrosRepo->getAllParameter();
        $tusuario = new Tusuario();
        $form = $this->createForm(TusuarioType::class, $tusuario,[
            'parameters' => $parameters,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tusuario);
            $entityManager->flush();

            return $this->redirectToRoute('app_tusuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tusuario/new.html.twig', [
            'tusuario' => $tusuario,
            'form' => $form,
        ]);
    }

    public function show(Tusuario $tusuario): Response
    {
        return $this->render('tusuario/show.html.twig', [
            'tusuario' => $tusuario,
        ]);
    }

    public function edit(Request $request, Tusuario $tusuario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TusuarioType::class, $tusuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tusuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tusuario/edit.html.twig', [
            'tusuario' => $tusuario,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, Tusuario $tusuario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tusuario->getIdUsuario(), $request->request->get('_token'))) {
            $entityManager->remove($tusuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tusuario_index', [], Response::HTTP_SEE_OTHER);
    }

    public function getdata(TusuarioRepository $tpersonaRepository): Response
    {
        $tusuarios = $tpersonaRepository->findAll();

        return $this->json([
            'data' => $tusuarios
        ]);

    }
}
