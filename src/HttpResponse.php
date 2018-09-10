<?php

declare(strict_types=1);

namespace Realconnex;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class HttpResponse extends Response
{
    /** @var array */
    public $headers = ['Content-Type' => 'application/json'];

    protected $statusCode = Response::HTTP_OK;

    /** @var SerializerInterface */
    private $serializer;

    /** @var array */
    private $data = [];

    /** @var array */
    private $context = [];

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @deprecated
     *
     * use setItems(array $items) method
     */
    public function setData(array $data) : self
    {
        $this->data[HttpResponseFields::F_ITEMS] = $data;

        return $this;
    }

    public function setItems(array $items) : self
    {
        $this->data[HttpResponseFields::F_ITEMS] = $items;

        return $this;
    }

    public function setPage(int $page) : self
    {
        $this->data[HttpResponseFields::F_PAGE] = $page;

        return $this;
    }

    public function setLimit(int $limit) : self
    {
        $this->data[HttpResponseFields::F_LIMIT] = $limit;

        return $this;
    }

    public function setOffset(int $offset) : self
    {
        $this->data[HttpResponseFields::F_OFFSET] = $offset;

        return $this;
    }

    public function setTotalPages(int $pages) : self
    {
        $this->data[HttpResponseFields::F_TOTAL_PAGES] = $pages;

        return $this;
    }

    public function setNextPage(?int $page) : self
    {
        $this->data[HttpResponseFields::F_NEXT_PAGE] = $page;

        return $this;
    }

    public function setPrevPage(?int $page) : self
    {
        $this->data[HttpResponseFields::F_PREV_PAGE] = $page;

        return $this;
    }

    public function setResult(bool $result) : self
    {
        $this->data[HttpResponseFields::F_RESULT] = $result;

        return $this;
    }

    public function setSerializationGroups(array $groups) : self
    {
        $this->context[HttpResponseFields::F_CONTEXT_GROUPS] = $groups;

        return $this;
    }

    public function setSerializationDepth(int $depth) : self
    {
        $this->context[HttpResponseFields::F_CONTEXT_DEPTH] = $depth;

        return $this;
    }

    /**
     * method cleans all previous context data and sets new
     *
     * @param array $context
     *
     * @return HttpResponse
     */
    public function setSerializationContext(array $context) : self
    {
        $this->context = $context;

        return $this;
    }

    public function setHeaders(array $headers) : self
    {
        $this->headers = array_merge(['Content-Type' => 'application/json'], $headers);

        return $this;
    }

    public function setContent($data)
    {
        $this->data = $data;

        return $this;
    }

    public function sendResponse()
    {
        $this->content = $this->serialize($this->data);
        parent::__construct($this->content, $this->statusCode, $this->headers);

        return $this;
    }

    private function serialize($content)
    {
        return $this->serializer->serialize($content, 'json', $this->context);
    }
}
