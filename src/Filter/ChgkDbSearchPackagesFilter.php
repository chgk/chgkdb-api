<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Search\ChgkDbSearchInterface;
use App\Search\SearchDateFilterSetter;
use App\Search\SearchOrderFilterSetter;
use App\Search\SearchQueryFilterSetter;
use App\Search\SearchPackagesFilterFactory;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ChgkDbSearchTournamentsFilter
 */
class ChgkDbSearchPackagesFilter implements FilterInterface
{
    /**
     * @var SearchPackagesFilterFactory
     */
    private SearchPackagesFilterFactory $searchTournamentsFilterFactory;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var ChgkDbSearchInterface
     */
    private ChgkDbSearchInterface $chgkDbSearch;

    /**
     * @param RequestStack $requestStack
     * @param SearchPackagesFilterFactory $searchTournamentsFilterFactory
     * @param ChgkDbSearchInterface $chgkDbSearch
     */
    public function __construct(
        RequestStack $requestStack,
        SearchPackagesFilterFactory $searchTournamentsFilterFactory,
        ChgkDbSearchInterface $chgkDbSearch
    ) {
        $this->searchTournamentsFilterFactory = $searchTournamentsFilterFactory;
        $this->requestStack = $requestStack;
        $this->chgkDbSearch = $chgkDbSearch;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     */
    public function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return;
        }
        $searchFilter = $this->searchTournamentsFilterFactory->createFromRequest($request);
        if (!$searchFilter->exists()) {
            return;
        }

        $ids = $this->chgkDbSearch->searchPackages($searchFilter);
        $alias = $queryBuilder->getAllAliases()[0];
        if (!$ids) {
            $queryBuilder->andWhere("0");
        }
        $queryBuilder->andWhere("$alias.id in (:sphinx_ids)")
            ->setParameter('sphinx_ids', $ids);
        $queryBuilder->addOrderBy(sprintf("Field($alias.id, :sphinx_ids)"));
    }

    /**
     * @param string $resourceClass
     * @return array[]
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            SearchQueryFilterSetter::PARAM_QUERY => [
                'property' => null,
                'name' => 'query',
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Search query',
                ],
            ],
            SearchDateFilterSetter::PARAM_DATE_FROM => [
                'property' => null,
                'name' => SearchDateFilterSetter::PARAM_DATE_FROM,
                'type' => 'date',
                'required' => false,
                'openapi' => [
                    'schema' => [
                        'type' => 'date',
                    ],
                    'description' => 'Start date'
                ]
            ],
            SearchDateFilterSetter::PARAM_DATE_TO => [
                'property' => null,
                'name' => SearchDateFilterSetter::PARAM_DATE_TO,
                'type' => 'date',
                'required' => false,
                'openapi' => [
                    'schema' => [
                        'type' => 'date',
                    ],
                    'description' => 'Finish date'
                ]
            ],
            SearchOrderFilterSetter::PARAM_ORDER_BY => [
                'property' => null,
                'name' => SearchOrderFilterSetter::PARAM_ORDER_BY,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Order parameter',
                    'name' => SearchOrderFilterSetter::PARAM_ORDER_BY,
                    'schema' => [
                        'type' => 'string',
                        'enum' => [ChgkDbSearchInterface::ORDER_DATE],
                    ],
                ],
            ],
            SearchOrderFilterSetter::PARAM_DESC => [
                'property' => null,
                'name' => SearchOrderFilterSetter::PARAM_DESC,
                'type' => 'boolean',
                'required' => false,
                'openapi' => [
                    'schema' => [
                        'type' => 'boolean',
                    ],
                    'description' => 'Use descending order.',
                ]
            ]
        ];
    }
}