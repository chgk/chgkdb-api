<?php
declare(strict_types=1);

namespace App\Search;

use App\Dto\SearchQuestionFilterDto;
use App\Dto\SearchPackageFilterDto;
use Javer\SphinxBundle\Sphinx\Manager;

class ChgkDbSphinxSearch implements ChgkDbSearchInterface
{
    /**
     * @var Manager
     */
    private $manager;

    public function __construct(
        Manager $manager
    ) {
        $this->manager = $manager;
    }

    /**
     * @param SearchPackageFilterDto $searchPackageFilterDto
     * @return string[]
     */
    public function searchPackages(SearchPackageFilterDto $searchPackageFilterDto)
    {
        $query = $this->manager->createQuery()
            ->from('chgk_tournaments')
            ->select('TextId')
            ->limit(0, 1000);
        if ($searchPackageFilterDto->getQuery()) {
            $searchString = $this->prepareSearchString($searchPackageFilterDto->getQuery());
            $query->match(['Title'], $searchString, true);
        }
        if ($searchPackageFilterDto->getDateFrom()) {
            $query->where('playdate', '>=', $searchPackageFilterDto->getDateFrom()->getTimestamp());
        }

        if ($searchPackageFilterDto->getDateTo()) {
            $query->where('playdate', '<=', $searchPackageFilterDto->getDateTo()->getTimestamp());
        }
        if ($searchPackageFilterDto->getOrderBy()) {
            $order = $searchPackageFilterDto->getOrderBy();
            $direction = $searchPackageFilterDto->isOrderDesc() ? 'DESC' : 'ASC';
            if ($order === self::ORDER_DATE) {
                $query->orderBy('playdate', $direction);
            }
        }
        $results = $query->getResults();

        return array_map(fn($a) => $a['textid'], $results);
    }
    /**
     * @param SearchQuestionFilterDto $searchQuestionFilterDto
     * @return string[]
     */
    public function searchQuestions(SearchQuestionFilterDto $searchQuestionFilterDto)
    {
        $query = $this->manager->createQuery()
            ->from('chgk_questions')
            ->select('TextId')
            ->limit(0,1000);

        if ($searchQuestionFilterDto->getQuery()) {
            $searchString = $this->prepareSearchString($searchQuestionFilterDto->getQuery());
            if ($searchQuestionFilterDto->isAnyWord()) {
                $searchString = preg_replace('/[\s|]+/', ' | ', $searchString);
            }

            $query->match($searchQuestionFilterDto->getFields(), $searchString, true);
        }
        $query->where('Type', 'IN', $searchQuestionFilterDto->getQuestionTypes() ?: ChgkDbSearchInterface::ALL_TYPES);

        if ($searchQuestionFilterDto->getDateFrom()) {
            $query->where('playdate', '>=', $searchQuestionFilterDto->getDateFrom()->getTimestamp());
        }

        if ($searchQuestionFilterDto->getDateTo()) {
            $query->where('playdate', '<=', $searchQuestionFilterDto->getDateTo()->getTimestamp());
        }

        if ($searchQuestionFilterDto->getOrderBy()) {
            $order = $searchQuestionFilterDto->getOrderBy();
            $direction = $searchQuestionFilterDto->isOrderDesc() ? 'DESC' : 'ASC';
            if ($order === self::ORDER_DATE) {
                $query->orderBy('playdate', $direction);
            } elseif ($order === self::ORDER_RANDOM) {
                $query->orderByRand();
            }
        }

        $results = $query->getResults();

        return array_map(fn($a) => $a['textid'], $results);
    }

    /**
     * @param string $searchString
     * @return string
     */
    private function prepareSearchString(string $searchString)
    {
        $searchString = addcslashes(trim($searchString), "'\\");

        return $searchString;
    }
}