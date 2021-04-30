<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);

        $form->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1), 10);
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
        return $this->render('property/index.html.twig', ['current_menu' => 'properties',
        'properties' => $properties,
        'form' => $form->createView()]);
    }


    /**
     * Undocumented function
     *@Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-zA-Z\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
    {
        $propertySlug = $property->getSlug();
        if($propertySlug!== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $propertySlug
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a ete bien envoye');

/*             return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $propertySlug
            ]); */
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
