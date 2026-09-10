<?php

namespace App\Http;

use InvalidArgumentException;

final class Pagination
{
    public readonly int $page;
    public readonly int $totalPages;
    public readonly int $offset;

    public function __construct(int $total, int $requestedPage, public readonly int $perPage = 5)
    {
        if ($total < 0 || $perPage < 1) {
            throw new InvalidArgumentException('Invalid pagination parameters.');
        }
        $this->totalPages = intdiv($total, $perPage) + ($total % $perPage > 0 ? 1 : 0);
        $this->page = max(1, min($requestedPage, max(1, $this->totalPages)));
        $this->offset = ($this->page - 1) * $perPage;
    }

    public function links(string $keyword = ''): array
    {
        if ($this->totalPages < 2) {
            return [];
        }

        $pages = [1, $this->totalPages];
        $end = $this->page + min(2, $this->totalPages - $this->page);
        for ($page = max(1, $this->page - 2); ; $page++) {
            $pages[] = $page;
            if ($page === $end) {
                break;
            }
        }
        $pages = array_values(array_unique($pages));
        sort($pages);
        $links = [];
        $previous = 0;
        foreach ($pages as $page) {
            if ($previous && $page - $previous > 1) {
                $links[] = ['page' => null, 'url' => '', 'active' => false];
            }
            $links[] = ['page' => $page, 'url' => $this->url($page, $keyword), 'active' => $page === $this->page];
            $previous = $page;
        }
        return $links;
    }

    public function previousUrl(string $keyword = ''): string
    {
        return $this->page > 1 ? $this->url($this->page - 1, $keyword) : '';
    }

    public function nextUrl(string $keyword = ''): string
    {
        return $this->page < $this->totalPages ? $this->url($this->page + 1, $keyword) : '';
    }

    private function url(int $page, string $keyword): string
    {
        return Url::product('list', ['page' => $page, 'keyword' => $keyword]);
    }
}
