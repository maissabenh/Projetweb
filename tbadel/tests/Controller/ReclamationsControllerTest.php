<?php

namespace App\Test\Controller;

use App\Entity\Reclamations;
use App\Repository\ReclamationsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReclamationsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReclamationsRepository $repository;
    private string $path = '/reclamation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Reclamations::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reclamation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'reclamation[subject]' => 'Testing',
            'reclamation[message]' => 'Testing',
            'reclamation[status]' => 'Testing',
            'reclamation[createdAt]' => 'Testing',
            'reclamation[email]' => 'Testing',
        ]);

        self::assertResponseRedirects('/reclamation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reclamations();
        $fixture->setSubject('My Title');
        $fixture->setMessage('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reclamation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reclamations();
        $fixture->setSubject('My Title');
        $fixture->setMessage('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reclamation[subject]' => 'Something New',
            'reclamation[message]' => 'Something New',
            'reclamation[status]' => 'Something New',
            'reclamation[createdAt]' => 'Something New',
            'reclamation[email]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reclamation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSubject());
        self::assertSame('Something New', $fixture[0]->getMessage());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getEmail());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Reclamations();
        $fixture->setSubject('My Title');
        $fixture->setMessage('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmail('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/reclamation/');
    }
}
