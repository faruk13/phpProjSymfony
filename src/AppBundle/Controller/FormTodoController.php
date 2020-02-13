<?php

// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormTodoController extends Controller
{
    public function newAction(Request $request)
    {
    // creates a task and gives it some dummy data for this example
//        $todo = new Todo();
//        $todo->setName('todo another');
//        $todo->setDescription('descrkrtorejogje');


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


        return $this->render('newtodo.html.twig', array('form' => $form->createView(),));
    }
}