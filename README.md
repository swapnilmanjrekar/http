# Caldera Http

Provides objects describing HTTP requests and responses as well as the ability to send HTTP requests. The request and response classes are extended by the rest-api package, which uses them to represent incoming REST API requests and responses. 

## 👀🌋 This Is A Module Of The [Caldera Framework](https://github.com/CalderaWP/caldera)
* 🌋 Find Caldera Forms Here:
    - [Caldera Forms on Github](http://github.com/calderawp/caldera-forms/)
    - [CalderaForms.com](http://calderaforms.com)
    
* 🌋 [Issues](https://github.com/CalderaWP/caldera/issues) and [pull requests](https://github.com/CalderaWP/caldera/pulls), should be submitted to the [main Caldera repo](https://github.com/CalderaWP/caldera/pulls).


## Overview
Request and response have the following public APIs

Request Only:
* `getParam($name)` - Get the value of a request  body (or query argument) field.
* `getParams()` - Get the values of all request body (or query argument) fields.
* `setParam($name,$value)` - Set the value of a request or response body (or query argument) field.

Response Only: 
* `getData()` - Get the values of all request body (or query argument) fields.
* `getStatus()` - Set the request HTTP method.
* `getStatus($code)` - Set the HTTP status method.

Request and Response
* `getHeader($name)` - Get the value of a request or response header.
* `getHeaders()` - Get the values of a all request or response headers.
* `setHeader($name,$value)` - Set the name of a request or response header.
* `getHttpMethod` - Get the request HTTP method.
* `setHttpMethod` - Set the request HTTP method.



## Usage

Main module class methods:

* `send()` - Send an HTTP request to the specified URL.
    - Supply a `Request` object and a URL. The response will be returned, represented by a `Response` object.
    - Uses Guzzle by default.
* `setClient()` Reset the HTTP client. 
    - Useful for testing. There is an example in [the phpunit cheatsheat](/docs/cheetsheets-and-links/cheatsheat-phpunit.md)
    - Could be used to add a different HTTP transport or something that pretends to be HTTP.

There are other public methods. They really should get moved to another class, as this class. Don't use them please.

### Install
* Add to your package:
    - `composer require calderawp/http`
* Install for development:
    - `git clone git@github.com:CalderaWP/http.git && composer install`


### Using

* Access from main container:
```php
$http = \caldera()->getHttp(); 
```

* Reset Client 
```php
        use GuzzleHttp\Handler\MockHandler;
        use GuzzleHttp\HandlerStack;
        use GuzzleHttp\Psr7\Response;
        
        //...
        
        $mockResponse = new Response(200, ['X-HELLO' => 'ROY'],
			json_encode(['messageFromServer' => 'Everything Is An Illusion.']));
		$mock = new MockHandler([
			$mockResponse,
		]);
		$handler = HandlerStack::create($mock);
		$client = new Client(['handler' => $handler]);
		\caldera()->getHttp()->setClient($client);
```

### Making A Remote HTTP Request
All HTTP requests are represented by the objects of the `Request` class and then passed to `CalderaHttp::send()`

* Create An Request Object
First, you need to create a request object:

```php
$apiRequest = new \calderawp\caldera\Http\Request();
$apiRequest->setHttpMethod('POST'); //how to dispatch 
$apiRequest->setParams([ 'stateOfMind' => 'Super Chill' ); //Request body
$apiRequest->setHeaders([ 'X-CONTENT-TYPE' => 'application/json' ] ); //Request headers
```

* Dispatch Request Object
Then you can dispatch your request. If the request is invalid and exception may be thrown -- by CalderaHttp or Guzzle. A generic catch is recommenced:

```php
try {
    $response = \caldera()
        ->getHttp()
        ->send($apiRequest, $url);
} catch (\Exception $e) {
    throw  $e;
}
```

* Using The Response

```php
$status = $response->getHeaders(); //All headers returned by remote API
$status = $response->getStatus(); //status code returned
$body = $response->getData();// body of remote request response
```


## Testing
* Run all tests (JK, just unit tests because that's the pattern)
    - `composer test`
* Run unit tests
    - `composer test:unit`
* Run acceptance tests
    - `composer test:acceptance`

    
## License, Copyright, etc.
Copyright 2018+ CalderaWP LLC and licensed under the terms of the GNU GPL license. Please share with your neighbor.
