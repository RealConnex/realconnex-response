# Realconnex HTTP Response package #

This is made to standardize service http responses

### Installation

```bash
$ composer require realconnex/http-response
```
Register class as a service in service.yml
```yaml
Realconnex\HttpResponse:
    autowire: true
```


To send simple response(e.g.: entity)
```php
public function getFeedById(Feeds $feed, HttpResponse $response) : HttpResponse
{
    return $response->setContent($feed)->sendResponse();
}
```
Or if result is an array of data
```php
public function getFeeds(Request $request, HttpResponse $response) : HttpResponse
{
    $page = (int)$request->get('page', 1);
    $limit = (int)$request->get('limit', 20);
    $data = $this->repository->list($page, $limit);

    return $response
        ->setItems($items)
        ->setPage($currentPage)
        ->setTotalPages($totalPages])
        ->setNextPage($nextPage)
        ->setPrevPage($prevPage)
        ->setLimit($limit)
        ->sendResponse();
}
```
Or operation result
```php
public function deleteFeed(Feeds $feed, HttpResponse $response) : HttpResponse
{
    return $response->setResult($this->repository->delete($feed))->sendResponse();
}
```
If you don't want to send response variable through parameters you can instantiate in manually, but you should send serializer in HttpResponse constructor
```php
$response = new HttpResponse(SerializerInterface $serializer);
$response->setItems($items)->sendResponse();
```

NOTE: You MUST send response at the end like ``->sendResponse();``

### List of allowed setters

```php
setItems(array $items = [])
setLimit(int $limit)
setPage(int $page)
setOffset(?int $page)
setTotalPages(int $pages)
setNextPage(?int $page)
setPrevPage(?int $page)
setSerializationGroups(array $groups = ['out'])
setHeaders(array $headers = ['Content-Type' => 'application/json'])
setStatusCode(int $status = 200)
```

