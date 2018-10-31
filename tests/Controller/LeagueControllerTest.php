<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 27/10/2018
 * Time: 19:06
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeagueControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', 'leagues');
        $list = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(2, count($list->data));
    }

    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', 'leagues/1');

        $json = json_decode($client->getResponse()->getContent());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Premier League', $json->data->name);
    }

    public function testShow404()
    {
        $client = static::createClient();

        // Sure the Id is not available.
        $client->request('GET', 'leagues/99');

        // Return 404
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
