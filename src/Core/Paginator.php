<?php

namespace App\Core;

use App\Repository\TaskRepository;

class Paginator
{

    // todo: duplication
    const ITEMS_PER_PAGE = 3;

    protected $current;

    public function __construct(Request $request, TaskRepository $repo)
    {
        $this->request = $request;
        $this->repo = $repo;

        $this->current = $this->setCurrentPage();
    }

    public function view()
    {
        $html = '<nav aria-label="Page navigation example"><ul class="pagination">';

        for ($i = 1; $i <= $this->getPagesCount(self::ITEMS_PER_PAGE); $i++) {

            $disabled = $i == $this->current ? ' disabled' : '';
            $href = $this->resolvePageHref($i);

            $html .= '<li class="page-item' . $disabled . '"><a class="page-link" href="' . $href . '">' . $i . '</a></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }

    private function setCurrentPage()
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

        $requestUri = $this->request->getRequestUri();

        $queryParams = $this->request->getQueryParams();
        unset($queryParams['page']);

        $queryString = $this->request->getQueryStringFromParams($queryParams);

        if (preg_match('~(.*)\?.*~', $requestUri, $match)) {
            $routePath = $match[1];
        }

        $href .= $routePath . '?' . $queryString;
        $href .= $queryString ? '&page=' . $i : 'page=' . $i;

        return $href;
    }
}