<?php
declare(strict_types=1);

namespace App\Search;

use App\Dto\SearchQuestionFilterDto;
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
     * @param SearchQuestionFilterDto $searchFilterDto
     * @return array
     */
    public function searchQuestions(SearchQuestionFilterDto $searchFilterDto)
    {
        $query = $this->manager->createQuery()
            ->from('chgk_questions')
            ->select('TextId')
            ->limit(0,1000);

        if ($searchFilterDto->getQuery()) {
            $searchString = addcslashes(trim($searchFilterDto->getQuery()), "'\\");

            if ($searchFilterDto->isAnyWord()) {
                $searchString = preg_replace('/[\s|]+/', ' | ', $searchString);
            }
            $query->match($searchFilterDto->getFields(), $searchString, true);
        }
        $query->where('Type', 'IN', $searchFilterDto->getQuestionTypes() ?: ChgkDbSearchInterface::ALL_TYPES);

        if ($searchFilterDto->getDateFrom()) {
            $query->where('playdate', '>=', $searchFilterDto->getDateFrom()->getTimestamp());
        }

        if ($searchFilterDto->getOrderBy()) {
            $order = $searchFilterDto->getOrderBy();
            $direction = $searchFilterDto->isOrderDesc() ? 'DESC' : 'ASC';
            if ($order === self::ORDER_DATE) {
                $query->orderBy('playdate', $direction);
            } elseif ($order === self::ORDER_RANDOM) {
                $query->orderByRand();
            }
        }

        if ($searchFilterDto->getDateTo()) {
            $query->where('playdate', '<=', $searchFilterDto->getDateTo()->getTimestamp());
        }

        $results = $query->getResults();

        return array_map(fn($a) => $a['textid'], $results);
    }
}