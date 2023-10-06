<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\State;
use App\Entity\Vehicle;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_CLIENT")'))]
class ReservationController extends AbstractController
{
    #[Route('/reservation/{id?}', name: 'app_reservation')]
    public function index(EntityManagerInterface $em, Request $request,?int $id): Response
    {
        $reservation = new Reservation();
        if ($id != null)
            $reservation->setVehicle($em->getRepository(Vehicle::class)->find($id));
        $reservation->setReference(rand(100000,999999));
        $reservation->setState($em->getRepository(State::class)->findAll()[2]);
        $reservation->setUserr($this->getUser());
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $reservation = $form->getData();
//            $reservationsEnCours = $em->getRepository(Reservation::class)->findCurrentReservation();
//            $isGood = false;
//            foreach ($reservationsEnCours as $reservationEnCours){
//                if ($reservationEnCours->getVehicle()->getId()==$reservation->getVehicle()->getId()){
//                    $isGood = true;
//                }
//            }
//            if ($isGood){
                $em->persist($reservation);
                $em->flush();
//            }
            return $this->redirectToRoute("app_home");
        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form
        ]);
    }
}
