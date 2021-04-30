<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Exception\NoConfigurationException;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     *
     * @return Response
     */
    public function index( PropertyRepository $repository, LoggerInterface $logger): Response
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}
