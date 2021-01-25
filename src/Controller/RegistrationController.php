<?php
namespace App\Controller;

use App\Entity\Basket;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user->setPassword(
                $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                if (!$user->getPassword()) {
                    throw new Exception("Hasło nie zostało poprawnie zakodowane");
                    
                }
                $basket = new Basket($this->user);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->persist($basket);
                $entityManager->flush();
                
                return $this->redirectToRoute('index', ['message' => 'Konto zostało poprawnie założone', 'typeMessage' => 'success']);
            } catch (\Exception $e) {
                return $this->redirectToRoute('register', ['message' => $e->getMessage(), 'typeMessage' => 'fail']);
            }
            

            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}