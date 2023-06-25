<?php
/**
 * Ad service.
 */

namespace App\Service;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AdService.
 */
class AdService implements AdServiceInterface
{
    /**
     * Ad repository.
     */
    private AdRepository $adRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param AdRepository     $adRepository Ad repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(AdRepository $adRepository, PaginatorInterface $paginator)
    {
        $this->adRepository = $adRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->adRepository->queryAll(),
            $page,
            AdRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Ad $ad ad entity
     */
    public function save(Ad $ad): void
    {
        $this->adRepository->save($ad);
    }

    /**
     * Delete entity.
     *
     * @param Ad $ad Ad entity
     */
    public function delete(Ad $ad): void
    {
        $this->adRepository->delete($ad);
    }

}
