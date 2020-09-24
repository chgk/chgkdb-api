<?php


namespace App\Search;

use App\Dto\SearchDateFilterDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SearchDateFilterSetter
{
    const PARAM_DATE_FROM = 'dateFrom';

    const PARAM_DATE_TO = 'dateTo';

    /**
     * @param Request $request
     * @param SearchDateFilterDtoInterface $result
     */
    public function setDates(Request $request, SearchDateFilterDtoInterface $result)
    {
        if ($request->query->has(self::PARAM_DATE_FROM)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $request->query->get(self::PARAM_DATE_FROM));
            if (!$date) {
                throw new BadRequestHttpException('Invalid parameter ' . self::PARAM_DATE_FROM);
            }
            $result->setDateFrom($date);
        }
        if ($request->query->has(self::PARAM_DATE_TO)) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $request->query->get(self::PARAM_DATE_TO));
            if (!$date) {
                throw new BadRequestHttpException('Invalid parameter ' . self::PARAM_DATE_TO);
            }
            $result->setDateTo($date);
        }
    }
}