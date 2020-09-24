<?php

namespace App\Search;

use App\Dto\SearchQuestionFilterDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class SearchQuestionsFilterFactory
 */
class SearchQuestionsFilterFactory
{
    const PARAM_FIELDS = 'field';

    const PARAM_QUESTION_TYPES = 'questionType';

    const PARAM_ANY_WORD = 'anyWord';

    const DEFAULT_FIELDS = [
        ChgkDbSearchInterface::FIELD_QUESTION,
        ChgkDbSearchInterface::FIELD_ANSWER,
        ChgkDbSearchInterface::FIELD_PASS_CRITERIA,
        ChgkDbSearchInterface::FIELD_COMMENTS
    ];

    /**
     * @var SearchDateFilterSetter
     */
    private SearchDateFilterSetter $searchDateFilterSetter;

    /**
     * @var SearchOrderFilterSetter
     */
    private SearchOrderFilterSetter $searchOrderFilterSetter;

    /**
     * @var SearchQueryFilterSetter
     */
    private SearchQueryFilterSetter $searchQueryFilterSetter;

    /**
     * @param SearchDateFilterSetter $searchDateFilterSetter
     * @param SearchOrderFilterSetter $searchOrderFilterSetter
     * @param SearchQueryFilterSetter $searchQueryFilterSetter
     */
    public function __construct(
        SearchDateFilterSetter $searchDateFilterSetter,
        SearchOrderFilterSetter $searchOrderFilterSetter,
        SearchQueryFilterSetter $searchQueryFilterSetter
    ) {
        $this->searchDateFilterSetter = $searchDateFilterSetter;
        $this->searchOrderFilterSetter = $searchOrderFilterSetter;
        $this->searchQueryFilterSetter = $searchQueryFilterSetter;
    }

    /**
     * @param Request $request
     * @return SearchQuestionFilterDto
     */
    public function createFromRequest(Request $request)
    {
        $result = new SearchQuestionFilterDto();
        $this->searchDateFilterSetter->setDates($request, $result);
        $this->searchOrderFilterSetter->setOrder($request, $result);
        $this->searchQueryFilterSetter->setQuery($request, $result);

        $this->setFields($request, $result);
        $this->setTypes($request, $result);
        $this->setAnyWord($request, $result);

        return $result;
    }

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setFields(Request $request, SearchQuestionFilterDto $result): void
    {
        if ($request->query->has(self::PARAM_FIELDS)) {
            $fields = $request->query->get(self::PARAM_FIELDS);
            if (!is_array($fields)) {
                throw new BadRequestHttpException(self::PARAM_FIELDS . ' should be array');
            }
            $result->setFields($fields);
        } else {
            $result->setFields(self::DEFAULT_FIELDS);
        }
    }

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setTypes(Request $request, SearchQuestionFilterDto $result): void
    {
        if ($request->query->has(self::PARAM_QUESTION_TYPES)) {
            $types = $request->query->get(self::PARAM_QUESTION_TYPES);
            if (!is_array($types)) {
                throw new BadRequestHttpException(self::PARAM_QUESTION_TYPES . ' should be array');
            }
            $diff = array_diff($types, ChgkDbSearchInterface::ALL_TYPE_PARAMS);
            if ($diff) {
                throw new BadRequestHttpException('Invalid question type(s): ' . implode(', ', $diff));
            }
            $result->setQuestionTypes(array_map(fn($a) => ChgkDbSearchInterface::PARAM_TYPE_MAP[$a], $types));
        }
    }

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setAnyWord(Request $request, SearchQuestionFilterDto $result): void
    {
        $result->setAnyWord($request->query->getBoolean(self::PARAM_ANY_WORD));
    }
}