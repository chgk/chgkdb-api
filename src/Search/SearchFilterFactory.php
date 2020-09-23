<?php

namespace App\Search;

use App\Dto\SearchQuestionFilterDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SearchFilterFactory
{
    const PARAM_QUERY = 'query';

    const PARAM_FIELDS = 'questionType';

    const PARAM_QUESTION_TYPES = 'type';

    const PARAM_ANY_WORD = 'anyWord';

    const PARAM_DATE_FROM = 'dateFrom';

    const PARAM_DATE_TO = 'dateTo';

    const PARAM_ORDER_BY = 'order';

    const PARAM_DESC = 'desc';

    const DEFAULT_FIELDS = [
        ChgkDbSearchInterface::FIELD_QUESTION,
        ChgkDbSearchInterface::FIELD_ANSWER,
        ChgkDbSearchInterface::FIELD_PASS_CRITERIA,
        ChgkDbSearchInterface::FIELD_COMMENTS
    ];
    public function createFromRequest(Request $request)
    {
        $result = new SearchQuestionFilterDto();
        $this->setQuery($request, $result);
        $this->setFields($request, $result);
        $this->setTypes($request, $result);
        $this->setAnyWord($request, $result);
        $this->setDates($request, $result);
        $this->setOrder($request, $result);

        return $result;
    }

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setQuery(Request $request, SearchQuestionFilterDto $result): void
    {
        if ($request->query->has(self::PARAM_QUERY)) {
            $result->setQuery($request->query->get(self::PARAM_QUERY));
        }
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

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setDates(Request $request, SearchQuestionFilterDto $result)
    {
        if ($request->query->has(self::PARAM_DATE_FROM)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $request->query->get(self::PARAM_DATE_FROM));
            if (!$date) {
                throw new BadRequestHttpException('Invalid parameter '.self::PARAM_DATE_FROM);
            }
            $result->setDateFrom($date);
        }
        if ($request->query->has(self::PARAM_DATE_TO)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $request->query->get(self::PARAM_DATE_TO));
            if (!$date) {
                throw new BadRequestHttpException('Invalid parameter '.self::PARAM_DATE_TO);
            }
            $result->setDateTo($date);
        }
    }

    /**
     * @param Request $request
     * @param SearchQuestionFilterDto $result
     */
    private function setOrder(Request $request, SearchQuestionFilterDto $result)
    {
        if ($request->query->has(self::PARAM_ORDER_BY)) {
            $orderBy = $request->query->get(self::PARAM_ORDER_BY);
            $isDesc = $request->query->getBoolean(self::PARAM_DESC);
            if (!in_array($orderBy, ChgkDbSearchInterface::ALL_ORDERS)) {
                throw new BadRequestHttpException('Invalid order by '.self::PARAM_DATE_TO);
            }
            $result->setOrderBy($orderBy);
            $result->setOrderDesc($isDesc);
        } elseif ($request->query->has(self::PARAM_DESC)) {
            throw new BadRequestHttpException(self::PARAM_DESC.' works only with '.self::PARAM_ORDER_BY.'='.ChgkDbSearchInterface::ORDER_DATE);
        }
    }
}