<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Jhkinfotech\Ticket\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Jhkinfotech\Ticket\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
