<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VehicleController extends AbstractController
{
    #[Route('/vehicle', name: 'app_vehicle')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vehicles = $entityManager->getRepository(Vehicle::class)->findAll();

        return $this->render('vehicle/index.html.twig', ['Vehicles'=>$vehicles]);
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/vehicle/update/{id?}', name: 'app_vehicle_update')]
    public function add(EntityManagerInterface $em, Request $request,?int $id): Response
    {
        if ($id == null)
            $vehicle = new Vehicle();
        else
            $vehicle=$em->getRepository(Vehicle::class)->find($id);

        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            if ($id == null)
                $em->persist($vehicle);
            $em->flush();
            return $this->redirectToRoute("app_vehicle");
        }

        return $this->render('vehicle/update.html.twig',["form"=>$form]);
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/vehicle/delete/{id}', name: 'app_vehicle_delete')]
    public function delete(EntityManagerInterface $entityManager,int $id): Response
    {
        $vehicles = $entityManager->getRepository(Vehicle::class)->find($id);
        $entityManager->remove($vehicles);
        $entityManager->flush();
        $vehicles = $entityManager->getRepository(Vehicle::class)->findAll();

        return $this->render('vehicle/index.html.twig', ['Vehicles'=>$vehicles]);
    }
}
