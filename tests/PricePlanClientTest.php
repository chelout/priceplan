<?php

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use PricePlan\PricePlanClient;
use PricePlan\Exceptions\PricePlanException;

class PricePlanClientTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected $guzzle;

    public function setUp()
    {
        $this->guzzle = Mockery::mock('GuzzleHttp\Client');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_client_get_request()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('GET', 'login', [
                'query' => [
                    'user' => 'user',
                    'password' => 'password',
                ]
            ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"success": true}');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->get('login', [
            'user' => 'user',
            'password' => 'password',
        ]);
    }

    public function test_client_post_request()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('POST', 'login', [
                'json' => [
                    'user' => 'user',
                    'password' => 'password',
                ]
            ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"success": true}');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->post('login', [
            'user' => 'user',
            'password' => 'password',
        ]);
    }

    public function test_client_put_request()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('PUT', 'login', [
                'json' => [
                    'user' => 'user',
                    'password' => 'password',
                ]
            ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"success": true}');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->put('login', [
            'user' => 'user',
            'password' => 'password',
        ]);
    }

    public function test_client_delete_request()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('DELETE', 'login', [
                'json' => [
                    'user' => 'user',
                    'password' => 'password',
                ]
            ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"success": true}');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->delete('login', [
            'user' => 'user',
            'password' => 'password',
        ]);
    }

    public function test_client_download_request()
    {
        $filePath = __DIR__.'/documents/test.pdf';
        $fileContents = file_get_contents($filePath);

        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('GET', 'download', [
                    'sink' => $filePath,
                ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn($fileContents);

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->download('download', $filePath);
    }

    public function test_client_handle_request_error()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('GET', 'error', [])
            ->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('объект не найден');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->get('error', []);
    }

    public function test_client_session_authentication()
    {
        $this->guzzle->shouldReceive('request')
            ->once()
            ->with('POST', 'login', [
                'json' => [
                    'user' => 'user',
                    'password' => 'password',
                ]
            ])->andReturn(
                $response = Mockery::mock('GuzzleHttp\Psr7\Response')
            );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"success": true}');

        $pricePlan = new PricePlanClient('test', $this->guzzle);
        $pricePlan->withSessionAuthentication('user', 'password');
    }

}