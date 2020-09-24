<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Search\ChgkDbSearchInterface;
use App\Search\SearchDateFilterSetter;
use App\Search\SearchOrderFilterSetter;
use App\Search\SearchQueryFilterSetter;
use App\Search\SearchQuestionsFilterFactory;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ChgkDbSearchQuestionsFilter
 */
class ChgkDbSearchQuestionsFilter implements FilterInterface
{
    /**
     * @var SearchQuestionsFilterFactory
     */
    private SearchQuestionsFilterFactory $searchQuestionsFilterFactory;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var ChgkDbSearchInterface
     */
    private ChgkDbSearchInterface $chgkDbSearch;

    /**
     * @param SearchQuestionsFilterFactory $searchFilterFactory
     * @param RequestStack $requestStack
     * @param ChgkDbSearchInterface $chgkDbSearch
     */
    public function __construct(
        SearchQuestionsFilterFactory $searchFilterFactory,
        RequestStack $requestStack,
        ChgkDbSearchInterface $chgkDbSearch
    ) {
        $this->searchQuestionsFilterFactory = $searchFilterFactory;
        $this->requestStack = $requestStack;
        $this->chgkDbSearch = $chgkDbSearch;
    }
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
            SearchQuestionsFilterFactory::PARAM_FIELDS.'[]' => [
                'property' => null,
                'name' => SearchQuestionsFilterFactory::PARAM_FIELDS.'[]',
                'type' => 'string',
                'is_collection' => true,
                'required' => false,
                'openapi' => [
                    'description' => 'Allows you to reduce search fields',
                    'name' => SearchQuestionsFilterFactory::PARAM_FIELDS.'[]',
                    'schema' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'string',
                            'enum' => ChgkDbSearchInterface::ALL_FIELDS,
                        ],
                    ],
                ],
            ],
            SearchQuestionsFilterFactory::PARAM_QUESTION_TYPES.'[]' => [
                'property' => null,
                'name' => SearchQuestionsFilterFactory::PARAM_QUESTION_TYPES.'[]',
                'type' => 'string',
                'is_collection' => true,
                'required' => false,
                'openapi' => [
                    'description' => 'Allows you to specify question types',
                    'name' => SearchQuestionsFilterFactory::PARAM_QUESTION_TYPES.'[]',
                    'schema' => [
                        'type' => 'array',
                        'items' => [
                            'type' => 'string',
                            'enum' => ChgkDbSearchInterface::ALL_TYPE_PARAMS,
                        ],
                    ],
                ],
            ],
            SearchQuestionsFilterFactory::PARAM_ANY_WORD => [
                'property' => null,
                'name' => SearchQuestionsFilterFactory::PARAM_ANY_WORD,
                'type' => 'boolean',
                'required' => false,
                'openapi' => [
                    'schema' => [
                        'type' => 'boolean',
                    ],
                    'description' => 'Search any word of the query. For backward compatibility -- use "word1 | word2 | word3"',
                    'deprecated' => true,
                ]
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
                        'enum' => ChgkDbSearchInterface::ALL_ORDERS,
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
                    'description' => 'Use descending order. Works only with order by date',
                ]
            ]
        ];
    }

    public function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return;
        }
        $searchFilter = $this->searchQuestionsFilterFactory->createFromRequest($request);
        if (!$searchFilter->exists()) {
            return;
        }
        $ids = $this->chgkDbSearch->searchQuestions($searchFilter);
        $alias = $queryBuilder->getAllAliases()[0];
        if (!$ids) {
            $queryBuilder->andWhere("0");
        }
        $queryBuilder->andWhere("$alias.id in (:sphinx_ids)")
            ->setParameter('sphinx_ids', $ids);
        $queryBuilder->addOrderBy(sprintf("Field($alias.id, :sphinx_ids)"));
    }
}