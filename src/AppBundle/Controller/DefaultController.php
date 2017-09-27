<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('author', TextType::class)
            ->add('year', TextType::class)
            ->add('numeric', TextType::class)
            ->add('search', SubmitType::class)
            ->getForm();

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            $searchFormData = $searchForm->getData();
        }

        $repository = $this->getDoctrine()->getRepository(Book::class);
        $searchResult = $repository->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'dataSet' => $searchResult,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
