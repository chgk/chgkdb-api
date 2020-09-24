<?php

namespace App\Search;

use App\Dto\SearchPackageFilterDto;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchPackagesFilterFactory
 */
class SearchPackagesFilterFactory
{
    /**
     * @var SearchQueryFilterSetter
     */
    private SearchQueryFilterSetter $searchQueryFilterSetter;
    /**
     * @var SearchDateFilterSetter
     */
    private SearchDateFilterSetter $searchDateFilterSetter;
    /**
     * @var SearchOrderFilterSetter
     */
    private SearchOrderFilterSetter $searchOrderFilterSetter;

    /**
     * @param SearchQueryFilterSetter $searchQueryFilterSetter
     * @param SearchDateFilterSetter $searchDateFilterSetter
     * @param SearchOrderFilterSetter $searchOrderFilterSetter
     */
    public function __construct(
        SearchQueryFilterSetter $searchQueryFilterSetter,
        SearchDateFilterSetter $searchDateFilterSetter,
        SearchOrderFilterSetter $searchOrderFilterSetter
    ) {
        $this->searchQueryFilterSetter = $searchQueryFilterSetter;
        $this->searchDateFilterSetter = $searchDateFilterSetter;
        $this->searchOrderFilterSetter = $searchOrderFilterSetter;
    }

    /**
     * @param Request $request
     * @return SearchPackageFilterDto
     */
    public function createFromRequest(Request $request)
    {
        $result = new SearchPackageFilterDto();
        $this->searchQueryFilterSetter->setQuery($request, $result);
        $this->searchDateFilterSetter->setDates($request, $result);
        $this->searchOrderFilterSetter->setOrder($request, $result);

        return $result;
    }
}