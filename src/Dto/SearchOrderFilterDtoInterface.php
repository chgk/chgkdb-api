<?php

namespace App\Dto;

/**
 * Interface SearchOrderFilterDtoInterface
 */
interface SearchOrderFilterDtoInterface
{
    /**
     * @return string|null
     */
    public function getOrderBy(): ?string;

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy(?string $orderBy): void;

    /**
     * @return bool
     */
    public function isOrderDesc(): bool;

    /**
     * @param bool $orderDesc
     */
    public function setOrderDesc(bool $orderDesc): void;
}