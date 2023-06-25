<?php
/**
 * Ad controller.
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Form\Type\AdType;
use App\Service\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AdController.
 */
#[Route('/ad')]
class AdController extends AbstractController
{
    /**
     * Ad service.
     */
    private AdServiceInterface $adService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param AdServiceInterface $adService  Ad service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(AdServiceInterface $adService, TranslatorInterface $translator)
    {
        $this->adService = $adService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'ad_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->adService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Ad $ad ad entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'ad_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Ad $ad): Response
    {
        return $this->render('show.html.twig', ['ad' => $ad]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'ad_create', methods: 'GET|POST', )]
    public function create(Request $request): Response
    {
        $ad = new Ad();
        $form = $this->createForm(
            AdType::class,
            $ad,
            ['action' => $this->generateUrl('ad_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adService->save($ad);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/create.html.twig',  ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Ad    $ad    Ad entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'ad_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(
            AdType::class,
            $ad,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('ad_edit', ['id' => $ad->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adService->save($ad);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('ad_index');
        }

        return $this->render(
            'ad/edit.html.twig',
            [
                'form' => $form->createView(),
                'ad' => $ad,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Ad    $ad    Ad entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'ad_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(
            FormType::class,
            $ad,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('ad_delete', ['id' => $ad->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adService->delete($ad);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('ad_index');
        }

        return $this->render(
            'ad/delete.html.twig',
            [
                'form' => $form->createView(),
                'ad' => $ad,
            ]
        );
    }
}
