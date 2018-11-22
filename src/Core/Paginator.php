<?php

namespace App\Core;

use App\Repository\TaskRepository;

class Paginator
{
    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $current;

    /**
     * Paginator constructor.
     * @param Request $request
     * @param TaskRepository $repo
     */
    public function __construct(Request $request, TaskRepository $repo)
    {
        $this->request = $request;
        $this->repo = $repo;

        $this->current = $this->resolveCurrentPageFromRequest();
    }

    /**
     * @param int $number
     */
    public function setItemsPerPage(int $number)
    {
        $this->itemsPerPage = $number;
    }

    public function view()
    {
        $html = '<nav aria-label="Page navigation example"><ul class="pagination">';

        for ($i = 1; $i <= $this->getPagesCount($this->itemsPerPage); $i++) {

            $disabled = $i == $this->current ? ' disabled' : '';
            $href = $this->resolvePageHref($i);

            $html .= '<li class="page-item' . $disabled . '"><a class="page-link" href="' . $href . '">' . $i . '</a></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }

    /**
     * @return int
     */
    private function resolveCurrentPageFromRequest()
    {
        $current = (int) $this->request->get('page');

        if (!$current) {
            return 1;
        }

        return $current;
    }

    /**
     * @param int $perPage
     * @return int
     */
    public function getPagesCount(int $perPage): int
    {
        $count = count($this->repo->findAll());

        return $count % $perPage == 0 ? $count / $perPage : $count / $perPage + 1;
    }

    /**
     * @param int $i
     * @return string
     */
    public function resolvePageHref(int $i): string
    {
        $href = '';
        $queryParams = $this->request->getQueryParams();
        unset($queryParams['page']);

        $queryString = $this->request->getQueryStringFromParams($queryParams);

        if (preg_match('~(.*)\?.*~', $this->request->getRequestUri(), $match)) {
            $routePath = $match[1];
        } else {
            $routePath = $this->request->getRequestUri();
        }

        $href .= $routePath . '?' . $queryString;
        $href .= $queryString ? '&page=' . $i : 'page=' . $i;

        return $href;
    }
}