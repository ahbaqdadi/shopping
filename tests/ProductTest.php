<?php
namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Product;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ProductTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/api/contexts/Product',
            '@id' => '/api/products',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/api/products?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/api/products?page=1',
                'hydra:last' => '/api/products?page=4',
                'hydra:next' => '/api/products?page=2',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(30, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
        $this->assertMatchesResourceCollectionJsonSchema(Product::class);
    }


    public function testCreateProduct(): void
    {
        $response = static::createClient()->request('POST', '/api/products', ['json' => [
            'title' => 'amir',
            'description' => 'Brilliantly conceived and executed, this powerful evocation of twenty-first century America gives full rein to Margaret Atwood\'s devastating irony, wit and astute perception.',
            'price' => 10,
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Product',
            '@type' => 'Product',
            'title' => 'amir',
            'description' => 'Brilliantly conceived and executed, this powerful evocation of twenty-first century America gives full rein to Margaret Atwood\'s devastating irony, wit and astute perception.',
            'price' => 10,
        ]);
        $this->assertMatchesRegularExpression('~^/api/products/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Product::class);
    }

    public function testUpdateProduct(): void
    {
        $client = static::createClient();
        // findIriBy allows to retrieve the IRI of an item by searching for some of its properties.
        // ISBN 9786644879585 has been generated by Alice when loading test fixtures.
        // Because Alice use a seeded pseudo-random number generator, we're sure that this ISBN will always be generated.
        $iri = $this->findIriBy(Product::class, ['title' => 'amir']);

        $client->request('PUT', $iri, ['json' => [
            'title' => 'sam'
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'title' => 'sam',
        ]);
    }

    public function testDeleteProduct(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Product::class, ['title' => 'amir']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
        // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
            static::$container->get('doctrine')->getRepository(Product::class)->findOneBy(['title' => 'amir'])
        );
    }
}
