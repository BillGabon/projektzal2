<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Form\Type\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;
    /**
     * Translator.
     */
    private TranslatorInterface $translator;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;

    }
    #[Route('/change_password', name: 'change_password', methods: 'GET|PUT')]
    public function edit(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(
            ChangePasswordType::class,
            $this->getUser(),
            [
                'method' => 'PUT',
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $newPassword
                )
            );
            $this->userRepository->save($user, 1);


            $this->addFlash(
                'success',
                $this->translator->trans('message.password_edited_successfully')
            );

            return $this->redirectToRoute('ad_index');
        }

        return $this->render(
            'user/password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $this->getUser(),
            ]
        );
    }
}
