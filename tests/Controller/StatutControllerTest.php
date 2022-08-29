<?php

namespace App\Test\Controller\Affaire;

use App\Entity\Affaire\Statut;
use App\Repository\Affaire\StatutRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatutControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StatutRepository $repository;
    private string $path = '/affaire/statut/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Statut::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Statut index');

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
            'statut[titre]' => 'Testing',
            'statut[couleur]' => 'Testing',
            'statut[couleurBG]' => 'Testing',
            'statut[destination]' => 'Testing',
        ]);

        self::assertResponseRedirects('/affaire/statut/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Statut();
        $fixture->setTitre('My Title');
        $fixture->setCouleur('My Title');
        $fixture->setCouleurBG('My Title');
        $fixture->setDestination('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Statut');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Statut();
        $fixture->setTitre('My Title');
        $fixture->setCouleur('My Title');
        $fixture->setCouleurBG('My Title');
        $fixture->setDestination('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'statut[titre]' => 'Something New',
            'statut[couleur]' => 'Something New',
            'statut[couleurBG]' => 'Something New',
            'statut[destination]' => 'Something New',
        ]);

        self::assertResponseRedirects('/affaire/statut/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getCouleur());
        self::assertSame('Something New', $fixture[0]->getCouleurBG());
        self::assertSame('Something New', $fixture[0]->getDestination());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Statut();
        $fixture->setTitre('My Title');
        $fixture->setCouleur('My Title');
        $fixture->setCouleurBG('My Title');
        $fixture->setDestination('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/affaire/statut/');
    }
}
