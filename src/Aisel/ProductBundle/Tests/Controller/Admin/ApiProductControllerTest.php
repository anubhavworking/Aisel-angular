<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Tests\Controller\Admin;

use Aisel\ResourceBundle\Tests\AbstractBackendWebTestCase;

/**
 * ApiProductControllerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiProductControllerTest extends AbstractBackendWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetProductsAction()
    {
        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertTrue(200 === $statusCode);
        $this->assertJson($content);
    }

    public function testPostProductActionFails()
    {
        $data = [
            'locale' => 'en',
            'name' => 'AAAAA',
            'sku' => time(),
            'price' => '100',
            'description' => time(),
            'description_short' => time(),
            'meta_url' => time(),
        ];

        $this->client->request(
            'POST',
            '/'. $this->api['backend'] . '/product/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->assertEmpty($content);
        $this->assertTrue(201 === $statusCode);
    }

    public function testPutProductAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['name' => 'AAAAA']);

        $category = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Category')
            ->findOneBy(['locale' => 'en']);

        $id = $product->getId();
        $data['locale'] = 'ru';

        $this->client->request(
            'PUT',
            '/'. $this->api['backend'] . '/product/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $this->dm->clear();

        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNotNull($product);
        $this->assertEquals($data['locale'], $product->getLocale());
    }

    public function testGetProductAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['name' => 'AAAAA']);

        $this->client->request(
            'GET',
            '/'. $this->api['backend'] . '/product/' . $product->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertTrue(200 === $statusCode);
        $this->assertEquals($result['id'], $product->getId());
    }

    public function testDeleteProductAction()
    {
        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['locale' => 'en']);
        $id = $product->getId();

        $this->client->request(
            'DELETE',
            '/'. $this->api['backend'] . '/product/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();

        $product = $this
            ->dm
            ->getRepository('Aisel\ProductBundle\Document\Product')
            ->findOneBy(['id' => $id]);

        $this->assertTrue(204 === $statusCode);
        $this->assertEmpty($content);
        $this->assertNull($product);
    }
}
