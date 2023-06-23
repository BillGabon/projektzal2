<?php
/**
 * Ad controller.
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Service\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * Constructor.
     */
    public function __construct(AdServiceInterface $taskService)
    {
        $this->adService = $taskService;
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
     * @param Ad $ad Ad
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'ad_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Ad $ad): Response
    {
        return $this->render('show.html.twig', ['ad' => $ad]);
    }
}
