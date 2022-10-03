<?php
namespace App\Tests\Controller;

use App\Controller\HelloController;
use App\Controller\HomeController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testHelloRandomRoute()
    {
        $client = static::createClient();

        $crawler = $client->request("GET", "/helloRandom");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Hello ", $crawler->filter("h1")->text());
    }

    function testRandomNameGenerator()
    {
        $rdName = HelloController::generateRandomName();
        $this->assertGreaterThan(1, strlen($rdName));
    }

    public function testHelloName()
    {
        $client = static::createClient();

        $crawler = $client->request("GET", "/hello/Dumbledore");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Dumbledore", $crawler->filter("h1")->text());
    }

    public function testHello(){

        $client = static::createClient();

        $crawler = $client->request("GET", "/hello");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(2, count(explode(' ', $crawler->filter('h1')->text())));

    }


}