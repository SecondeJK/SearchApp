<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $searchForm = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('author', TextType::class)
            ->add('year', ChoiceType::class, [
                "label" => "Year",
                "choices" => $this->getBookYears($repository)
                ]
            )
            ->add('numeric', TextType::class, ['label' => 'Genre'])
            ->add('search', SubmitType::class)
            ->add('reset', SubmitType::class, ['label' => 'Reset'])
            ->getForm();

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            $searchFormData = $searchForm->getData();
            
            if ($searchForm->get('reset')->isClicked()) {
                $this->redirectToRoute('homepage');
            }

            $query = $repository->createQueryBuilder('book');
            
            if ($searchFormData['title'] != null) {
                $query->andWhere('book.title LIKE :title')->setParameter('title', '%' . $searchFormData['title'] . '%');
            }
            
            if ($searchFormData['author'] != null) {
                $query->andWhere('book.author LIKE :author')->setParameter('author', '%' . $searchFormData['author'] . '%');
            }

            if ($searchFormData['year'] != (null || 'All')) {
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

    protected function getBookYears($repository):array
    {
        $allRecordsQuery = $repository->createQueryBuilder('book')
            ->groupBy('book.year')
            ->orderBy('book.year', 'ASC')
            ->getQuery();
        
        $allRecordsResult = $allRecordsQuery->getResult();

        $returnYears = [];
        $returnYears['All'] = 'All';

        foreach($allRecordsResult as $entity){
            $returnYears[$entity->getYear()] = $entity->getYear();
        }

        return $returnYears;
    }
}
