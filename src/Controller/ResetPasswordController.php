<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $request->get('email')));
            if ($user) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTimeImmutable());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                $url = $this->generateUrl('update_password', [

                    'token' => $reset_password->getToken()
                ]);
                $content = "Bonjour " . $user->getFirstname() . ",<br/>Vous avez a reinitialiser votre mote de passe sur notre site.<br/><br/>
             Merci de bien vouloir cliquer sur le liens suivant pour <a href='" . $url . "'>reinitialiser votre mot de passe</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname(), " Reinitialiser votre mot de passe sur MightyMamaCréa", $content);
                $this->addFlash('notice', 'Vous allez recevoir un mail avec la procedure pour renouveler votre mot de passe');
            } else {
                $this->addFlash('notice', 'Cette adresse email est inconnue');
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modifier-mon-mot-de-passe/{token}", name="update_password")
     */
    public function update(Request $request, $token, UserPasswordHasherInterface $encoder): Response
    {

        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneBy(array('token' => $token));
        if (!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();
            $password = $encoder->hashPassword($reset_password->getUser(), $new_pwd);

            $reset_password->getUser()->setPassword($password);
            $this->entityManager->flush();

            $this->addFlash('notice','Votre mot de passe a bien été mis à jour');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);
        // $now = new DateTime();
        // $mutable = new DateTime::createFromImmutable($reset_password->getCreatedAt());
        // if($now < $mutable->date_modify('+3 hour')){
        //     die('on est bon');
        // }
        // die('on est pas bon');


    }
}
