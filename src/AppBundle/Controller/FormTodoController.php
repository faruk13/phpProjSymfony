<?php

// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormTodoController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('todos/index.html.twig');
    }
    /**
     * @Route("/newtodo", name="New_Todo")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
    public function newAction(Request $request)
    {
        $todo = new Todo();

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('priority', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Todo'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $todo = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($todo);
             $entityManager->flush();
             $todoArray=['name'=> $todo->getName(), 'desc'=> $todo->getDescription(),'priority'=> $todo->getPriority()];
            # new Response("");
            return $this->json($todoArray);
            #return $this->redirectToRoute('task_success');
        }


        return $this->render('todos/newtodo.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/todo/delete/{id}", name="Todo_Delete")
     * @param $id
     * @return Response
     */
    public function deleteAction($id){


        $entityManager = $this->getDoctrine()->getManager();
        #$deleteTodo = $entityManager->getRepository(Todo::class)->findOneByName('This 1');
        $deleteTodo = $entityManager->getRepository(Todo::class)->find($id);
        #deleting by id

        $entityManager->remove($deleteTodo);
        $entityManager->flush();

        
        return new Response('Deleted todo with name '.$deleteTodo->getName().
            '<a href="/todo/display" class="btn btn-danger">Show all todos!</a>');

    }




}