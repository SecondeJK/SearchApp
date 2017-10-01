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
        $repository = $this->getDoctrine()->getRepository(Book::class);

        if ($searchForm->isSubmitted()) {
            $searchFormData = $searchForm->getData();

            $query = $repository->createQueryBuilder('book')
                ->where('book.title LIKE :title')
                ->orWhere('book.author LIKE :author')
                ->orWhere('book.year = :year')
                ->orWhere('book.numeric = :numeric')
                ->setParameter('title', '%' . $searchFormData['title'] . '%')
                ->setParameter('author', '%' . $searchFormData['author'] . '%')
                ->setParameter('year', $searchFormData['year'])
                ->setParameter('numeric', '%' . $searchFormData['numeric'] . '%')
                ->orderBy('book.title', 'ASC')
                ->getQuery();

            $dataSet = $query->getResult();
        } else {
            $dataSet = $repository->findAll();
        }


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'dataSet' => $dataSet,
            'searchForm' => $searchForm->createView()
        ]);
    }
}
