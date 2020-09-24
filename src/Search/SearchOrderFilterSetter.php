<?php

namespace App\Search;

use App\Dto\SearchOrderFilterDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SearchOrderFilterSetter
{
    public const PARAM_ORDER_BY = 'order';
    public const PARAM_DESC = 'desc';

    /**
     * @param Request $request
     * @param SearchOrderFilterDtoInterface $result
     */
    public function setOrder(Request $request, SearchOrderFilterDtoInterface $result)
    {
        if ($request->query->has(self::PARAM_ORDER_BY)) {
            $orderBy = $request->query->get(self::PARAM_ORDER_BY);
            $isDesc = $request->query->getBoolean(self::PARAM_DESC);
            if (!in_array($orderBy, ChgkDbSearchInterface::ALL_ORDERS)) {
                throw new BadRequestHttpException('Invalid order by ' . self::PARAM_ORDER_BY);
            }
            $result->setOrderBy($orderBy);
            $result->setOrderDesc($isDesc);
        } elseif ($request->query->has(self::PARAM_DESC)) {
            throw new BadRequestHttpException(self::PARAM_DESC . ' works only with ' . self::PARAM_ORDER_BY . '=' . ChgkDbSearchInterface::ORDER_DATE);
        }
    }
}