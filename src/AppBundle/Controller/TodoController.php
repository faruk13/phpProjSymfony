<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class TodoController extends Controller
{


    /**
     * @Route("/todo/create", name="Create_Todo")
     * @return Response
     */
    public function createAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $todo = new Todo();
        $todo->setName('This wqwq3');
        #$dat=DateTime::createFromFormat('j-M-Y', '15-Feb-2029');
        #$convertedDate=$dat->format('Y-m-d');
        $todo->setDescription('todo descqwq333');
        $todo->setPriority('high');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($todo);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        $todoArray=['name'=> $todo->getName(), 'desc'=> $todo->getDescription(),'priority'=> $todo->getPriority()  ];
        #array_push(, );
        #return new Response('Saved new todo with id ' . $todo->getId().' new todo name '.$todo->getName());
        return $this->json($todoArray);
    }


    /**
     * @Route("/todo/display")
     */
    public function displayAction()
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:Todo')
            ->findAll();
        $res=array();

        foreach ($todo as $ele){
            $todoArray=array ('name'=> $ele->getName(), 'desc'=> $ele->getDescription(),'priority'=> $ele->getPriority() );
            array_push($res, $todoArray);
        }
        /** @var TYPE_NAME $res */
        return $this->json($res);
    }

}
// if you have multiple entity managers, use the registry to fetch them

//
//
//
//
//    /**
//     * @Route("/todos", name="Todo_List")
//     * @param Request $request
//     * @return Response
//     */
//
//
//    public function listAction(Request $request){
//
//
//        return $this->render('todos/index.html.twig');
//    }
//
//    /**
//     * @Route("/todo/create", name="Create_Todo")
//     * @param Request $request
//     * @return Response
//     */
//    public function createAction(Request $request){
//        return $this->render('todos/create.html.twig');
//    }
//
//    /**
//     * @Route("/todo/edit/{id}", name="Edit_Todo")
//     * @param $id
//     * @param Request $request
//     * @return Response
//     */
//    public function editAction($id, Request $request){
//        return $this->render('todos/edit.html.twig');
//    }
//
//    /**
//     * @Route("/todo/details/{id}", name="Todo_Details")
//     * @param $id
//     * @return Response
//     */
//    public function detailsAction($id){
//
//        return $this->render('todos/display.html.twig');
//    }
//
//    /**
//     * @Route("/todo/delete/{id}", name="Todo_Delete")
//     * @param $id
//     * @return Response
//     */
//    public function deleteAction($id){
//
//        return $this->render('todos/delete.html.twig');
//    }

