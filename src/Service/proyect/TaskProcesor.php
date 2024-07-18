<?php

namespace App\Service\proyect;

use App\Entity\Tcatalogo;
use App\Entity\TgestionProyecto;
use App\Entity\Tparametros;
use App\Entity\Tproyecto;
use App\Entity\TtareaHito;
use Doctrine\ORM\EntityManagerInterface;

class TaskProcesor
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    public function processTasks($idProyecto, $data)
    {
        $result = array();
        $dataResult = array();
        $rowResult = array();
        $parameters = $this->em->getRepository(Tparametros::class)->getAllParameter();
        // Obtener todas las tareas existentes
        $existingTasks = $this->em->getRepository(TgestionProyecto::class)->getMainTask($idProyecto, $parameters['P_CAT_TASKDELE']);

        // Recorrer los datos enviados
        foreach ($data as $row) {
            $rowResult = $row;
            // Comprobar si la tarea ya existe en la base de datos
            $existingTask = $this->findExistingTask($existingTasks, $row['id']);

            if ($existingTask) {
                // Si la tarea existe, actualizar sus valores
                $this->updateTask($existingTask, $row);
            } else {
                // Si la tarea no existe, crear una nueva entidad y persistirla
                $newTask = $this->createNewTask($idProyecto, $row, $parameters['P_CAT_TASKNEW']);
                $this->em->persist($newTask);
                $rowResult['id'] = $newTask->getIdGestionProyecto();



            }
            // Eliminar las tareas que no están presentes en los datos enviados
            $this->deleteRemovedTasks($existingTasks, $data, $parameters['P_CAT_TASKDELE']);
            $this->em->flush();
            $dataResult[] = $rowResult;
        }

        if (count($data)==0){
            $this->deleteRemovedTasks($existingTasks, $data, $parameters['P_CAT_TASKDELE']);
            $this->em->flush();
        }
        $result['result'] = 'OK';
        $result['data'] = $dataResult;

        return $result;
    }

    private function findExistingTask(array $existingTasks, $taskId): ?Tgestionproyecto
    {
        foreach ($existingTasks as $task) {
            if ($task->getIdGestionProyecto() == $taskId) {
                return $task;
            }
        }
        return null;
    }

    private function updateTask(Tgestionproyecto $gestion, array $data): void
    {

        $task = $this->em->getRepository(TtareaHito::class)->findOneBy(
            ['idTareaHito' => $gestion->getIdTareaHito()->getIdTareaHito()]);


        // Actualizar los valores de la tabla Tgestiontarea
        $gestion->setCodigoGestion(intval($data['codigo']));
        $gestion->setCodigoGestionPadre($data['padre'] == '' ? null : $data['padre']);
        $gestion->setFinicio(new \DateTime($data['finicio']));
        $gestion->setFfin(new \DateTime($data['ffin']));
        $gestion->setPorcentajeAvance(intval($data['avance']));
        // Actualizar los valores de la tabla TtareaHito
        $task->setNombre($data['tarea']);
        $this->em->persist($gestion);
        $this->em->persist($task);

    }

    private function createNewTask($idProyecto, array $data, $idEstadoNuevo): Tgestionproyecto
    {
        $proyect = $this->em->getRepository(Tproyecto::class)->findOneBy(['idProyecto' => $idProyecto]);
        $estado = $this->em->getRepository(Tcatalogo::class)->findOneBy(['idCatalogo' => $idEstadoNuevo]);
        //Crea la tarea
        $newTask = new TtareaHito();
        $newTask->setNombre($data['tarea']);
        $this->em->persist($newTask);
        // Crear la gestión de la tarea
        $gestion = new Tgestionproyecto();
        $gestion->setCodigoGestion($data['codigo']);
        $gestion->setCodigoGestionPadre($data['padre'] == '' ? null : $data['padre']);
        $gestion->setPorcentajeAvance(intval($data['avance']));
        $gestion->setFinicio(new \DateTime($data['finicio']));
        $gestion->setFfin(new \DateTime($data['ffin']));
        $gestion->setIdEstado($estado);
        $gestion->setIdProyecto($proyect);
        $gestion->setIdTareaHito($newTask);

        return $gestion;
    }

    private function deleteRemovedTasks(array $existingTasks, array $data, $idEstateDelete): void
    {
        $estado = $this->em->getRepository(Tcatalogo::class)->findOneBy(['idCatalogo' => $idEstateDelete]);
        // Identificar las tareas que deben ser eliminadas

        foreach ($existingTasks as $task) {
            $taskId = $task->getIdGestionProyecto();
            $taskExistsInData = false;

            foreach ($data as $row) {
                if ($row['id'] == $taskId || $row['id'] = '') {
                    $taskExistsInData = true;
                    break;
                }
            }

            // Si la tarea no está presente en los datos enviados, eliminarla
            if (!$taskExistsInData) {
                $task->setIdEstado($estado);
                $this->em->persist($task);
            }
        }
    }

}