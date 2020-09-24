<?php

namespace App\Dto;

/**
 * Interface SearchQueryDtoInterface
 */
interface SearchQueryDtoInterface
{
    /**
     * @return string
     */
    public function getQuery() : string;

    /**
     * @param string $query
     */
    public function setQuery(string $query): void;
}