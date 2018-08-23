<?php

declare(strict_types=1);

namespace Realconnex;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpResponse extends Response
{
    const F_DATA = 'data';
    const F_LIMIT = 'limit';
    const F_PAGE = 'page';
    const F_OFFSET = 'offset';
    const F_TOTAL_PAGES = 'total_pages';
    const F_NEXT_PAGE = 'next_page';
    const F_PREV_PAGE = 'prev_page';
    const F_RESULT = 'result';

    public $headers = ['Content-Type' => 'application/json'];

    protected $statusCode = JsonResponse::HTTP_OK;

    private $serializer;

    private $data = [];

    private $groups = ['out'];

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function setData(array $data) : self
    {
        $this->data[self::F_DATA] = $data;

        return $this;
    }

    public function setPage(int $page) : self
    {
        $this->data[self::F_PAGE] = $page;

        return $this;
    }

    public function setLimit(int $limit) : self
    {
        $this->data[self::F_LIMIT] = $limit;

        return $this;
    }

    public function setOffset(int $offset) : self
    {
        $this->data[self::F_OFFSET] = $offset;

        return $this;
    }

    public function setTotalPages(int $pages) : self
    {
        $this->data[self::F_TOTAL_PAGES] = $pages;

        return $this;
    }

    public function setNextPage(?int $page) : self
    {
        $this->data[self::F_NEXT_PAGE] = $page;

        return $this;
    }

    public function setPrevPage(?int $page) : self
    {
        $this->data[self::F_PREV_PAGE] = $page;

        return $this;
    }

    public function setResult(bool $result) : self
    {
        $this->data[self::F_RESULT] = $result;

        return $this;
    }

    public function setSerializationGroups(array $groups) : self
    {
        array_merge($this->groups, $groups);

        return $this;
    }

    public function setHeaders(array $headers) : self
    {
        array_merge($this->headers, $headers);

        return $this;
    }

    public function setContent($data)
    {
        $this->data = $data;

        return $this;
    }

    public function sendResponse()
    {
        $this->content = $this->format($this->data);
        parent::__construct($this->content, $this->statusCode, $this->headers);

        return $this;
    }

    private function format($content)
    {
        return $this->serializer->serialize($content, 'json', [
            'groups' => $this->groups
        ]);
    }
}
