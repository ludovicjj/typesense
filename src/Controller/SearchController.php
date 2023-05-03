<?php

namespace App\Controller;

use ACSEO\TypesenseBundle\Finder\TypesenseQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(private $dataFinder)
    {
    }

    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        $wordToSearch = 'molestias';
        $query = new TypesenseQuery($wordToSearch, 'content');
        $rawResults = $this->dataFinder->rawQuery($query)->getResults();

        return $this->render('search/index.html.twig', [
            'results' => $rawResults,
        ]);
    }
}
