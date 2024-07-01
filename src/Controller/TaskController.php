<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class TaskController extends AbstractController
{
    private $serializer;
    private $entityManager;
    private $validator;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }
    
    #Fetching list of tasks
    public function index(): Response
    {
        $data = $this->entityManager->getRepository(Task::class)->findAll();
        $tasks = $this->serializer->serialize($data, 'json');

    return new Response($tasks, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        
    }

    
    #Fetching Each task by id
    public function showTask(int $id): Response
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            return $this->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializer->serialize($task, 'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    
    #Creating a task
    public function newTask(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->validator->validate($task);
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $taskData = $this->serializer->serialize($task, 'json');

            return new Response($taskData, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
        }

        $errors = $form->getErrors(true);
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages []= $error->getMessage();
        }

        return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }

    

    #Editing task by id
    public function editTask(Request $request, int $id): Response
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            return $this->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $data = $this->serializer->serialize($task, 'json');

            return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        }

        $errors = $form->getErrors(true);
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }


    #deleting a record
    public function deleteTask(int $id): Response
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            return $this->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->json(['message' => 'Task deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}