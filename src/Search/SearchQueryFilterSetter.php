<?php

namespace App\Search;

use App\Dto\SearchQueryDtoInterface;
use App\Dto\SearchQuestionFilterDto;
use Symfony\Component\HttpFoundation\Request;

class SearchQueryFilterSetter
{
    public const PARAM_QUERY = 'query';

    /**
     * @param Request $request
     * @param SearchQueryDtoInterface $result
     */
    public function setQuery(Request $request, SearchQueryDtoInterface $result): void
    {
        if ($request->query->has(self::PARAM_QUERY)) {
            $result->setQuery($request->query->get(self::PARAM_QUERY));
        }
    }
}