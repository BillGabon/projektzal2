<?php
/**
 * License block.
 */

namespace App\Controller;

use App\Service\UserServiceInterface;
use App\Form\Type\ChangeEmailType;
use App\Form\Type\ChangePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for user-related stuff.
 */
class UserController extends AbstractController
{
    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    private UserServiceInterface $userService;

    /** Constructor.
     * @param TranslatorInterface  $translator  translator
     * @param UserServiceInterface $userService User Service
     */
    public function __construct(TranslatorInterface $translator, UserServiceInterface $userService)
    {
        $this->translator = $translator;
        $this->userService = $userService;
    }

    /** Change Password route.
     * @param Request $request HTTP request
     *
     * @return Response response
     */
    #[Route('/change_password', name: 'change_password', methods: 'GET|POST')]
    #[IsGranted('ROLE_USER')]
    public function editPassword(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(
            ChangePasswordType::class,
            null,
            [
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();

            $this->addFlash(
                'success',
                $this->translator->trans('message.password_edited_successfully')
            );

            $this->userService->changePassword($user, $newPassword);

            return $this->redirectToRoute('ad_index');
        }

        return $this->render(
            'user/password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /** Change email route.
     * @param Request $request HTTP Request
     *
     * @return Response response
     */
    #[Route('/change_email', name: 'change_email', methods: 'GET|POST')]
    #[IsGranted('ROLE_USER')]
    public function editEmail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(
            ChangeEmailType::class,
            null,
            [
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newEmail = $form->get('newEmail')->getData();

            $this->addFlash(
                'success',
                $this->translator->trans('message.email_edited_successfully')
            );

            $this->userService->changeEmail($user, $newEmail);

            return $this->redirectToRoute('ad_index');
        }

        return $this->render(
            'user/email.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}
