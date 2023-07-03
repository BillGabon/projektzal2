<?php
/**
 * Ad service.
 */

namespace App\Service;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AdService.
 */
class AdService implements AdServiceInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Ad repository.
     */
    private AdRepository $adRepository;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param PaginatorInterface       $paginator       Paginator
     * @param AdRepository             $adRepository    Ad repository
     */
    public function __construct(CategoryServiceInterface $categoryService, PaginatorInterface $paginator, AdRepository $adRepository)
    {
        $this->categoryService = $categoryService;
        $this->paginator = $paginator;
        $this->adRepository = $adRepository;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->adRepository->queryAll($filters),
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

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}
