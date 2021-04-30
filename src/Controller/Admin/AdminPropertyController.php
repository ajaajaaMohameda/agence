<?php
namespace App\Controller\Admin;

use App\Entity\Option;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class AdminPropertyController extends AbstractController
{

    /**
     * Undocumented variable
     *
     * @var PropertyRepository
     */
    private $repository;

    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Undocumented function
     *
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * Undocumented function
     *@Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @return Response
     */
    public function edit(Property $property, Request $request)
    {
/*         $option = new Option();
        $property->addOption($option);
         */
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            
            $this->em->flush();
            $this->addFlash('success', 'Bien modifie avec succes');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', 
    [
        'property' => $property,
        'form' => $form->createView()
    ]);

    }

    /**
     * Undocumented function
     *
     * @Route("/admin/property/create", name="admin.property.new")
     * @return void
     */
    public function new(Request $request)
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien creee avec succes');

            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * Undocumented function
     *
     *@Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return Response
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $property->getId(), $request->get('_token'))) {

            $this->em->remove($property);
            $this->em->flush();
    
            $this->addFlash('success', 'Bien supprimer avec succes');
    
           return $this->redirectToRoute("admin.property.index");
        }
    }
}