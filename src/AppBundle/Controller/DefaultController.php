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
            dump($searchFormData);
            $query = $repository->createQueryBuilder('book');
            
            if ($searchFormData['title'] != null) {
                $query->andWhere('book.title LIKE :title')->setParameter('title', '%' . $searchFormData['title'] . '%');
            }
            
            if ($searchFormData['author'] != null) {
                $query->andWhere('book.author LIKE :author')->setParameter('author', '%' . $searchFormData['author'] . '%');
            }

            if ($searchFormData['year'] != null) {
                $query->andWhere('book.year = :year')->setParameter('year', $searchFormData['year']);
            }

            if ($searchFormData['numeric'] != null) {
                $query->andWhere('book.numeric = :numeric')->setParameter('numeric', '%' . $searchFormData['numeric'] . '%');
            }

            $query = $query->orderBy('book.title', 'ASC')->getQuery();

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
