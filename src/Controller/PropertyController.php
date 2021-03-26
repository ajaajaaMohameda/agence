<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;

class PropertyController extends AbstractController
{
    /**
     * Undocumented variable
     *
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;    
        $this->em = $em;
    }
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {
/*         $property = new Property();
        $property->setTitle('Mon premier bien')
                ->setPrice(2000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('une petite description')
                ->setSurface(60)
                ->setFloor(4)
                ->setHeat(1)
                ->setCity('Montpellier')
                ->setAddress('15 boulevard Gambetta')
                ->setPostalCode('3000');
        $em = $this->getDoctrine()->getManager();

        $em->persist($property);
        $em->flush(); */
        /* $repository = $this->getDoctrine()->getRepository(Property::class);
        dump($repository); */
        //$property = $this->repository->findAllVisible();
/*         $property[0]->setSold(true);

        $this->em->flush();
        dump($property); */
       // dump($property);
        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);
    }


    /**
     * Undocumented function
     *@Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-zA-Z\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        $propertySlug = $property->getSlug();
        if($propertySlug!== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $propertySlug
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
