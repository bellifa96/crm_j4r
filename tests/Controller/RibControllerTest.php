<?php

namespace App\Test\Controller\Society;

use App\Entity\Society\Rib;
use App\Repository\Society\RibRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RibControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RibRepository $repository;
    private string $path = '/society/rib/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Rib::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rib index');

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
            'rib[iban]' => 'Testing',
            'rib[bic]' => 'Testing',
            'rib[typeDeCompte]' => 'Testing',
            'rib[nomBanque]' => 'Testing',
            'rib[commentaire]' => 'Testing',
            'rib[etatDuCompte]' => 'Testing',
            'rib[createdAt]' => 'Testing',
            'rib[updatedAt]' => 'Testing',
            'rib[interlocuteur]' => 'Testing',
        ]);

        self::assertResponseRedirects('/society/rib/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rib();
        $fixture->setIban('My Title');
        $fixture->setBic('My Title');
        $fixture->setTypeDeCompte('My Title');
        $fixture->setNomBanque('My Title');
        $fixture->setCommentaire('My Title');
        $fixture->setEtatDuCompte('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setInterlocuteur('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rib');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rib();
        $fixture->setIban('My Title');
        $fixture->setBic('My Title');
        $fixture->setTypeDeCompte('My Title');
        $fixture->setNomBanque('My Title');
        $fixture->setCommentaire('My Title');
        $fixture->setEtatDuCompte('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setInterlocuteur('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rib[iban]' => 'Something New',
            'rib[bic]' => 'Something New',
            'rib[typeDeCompte]' => 'Something New',
            'rib[nomBanque]' => 'Something New',
            'rib[commentaire]' => 'Something New',
            'rib[etatDuCompte]' => 'Something New',
            'rib[createdAt]' => 'Something New',
            'rib[updatedAt]' => 'Something New',
            'rib[interlocuteur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/society/rib/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIban());
        self::assertSame('Something New', $fixture[0]->getBic());
        self::assertSame('Something New', $fixture[0]->getTypeDeCompte());
        self::assertSame('Something New', $fixture[0]->getNomBanque());
        self::assertSame('Something New', $fixture[0]->getCommentaire());
        self::assertSame('Something New', $fixture[0]->getEtatDuCompte());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getInterlocuteur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Rib();
        $fixture->setIban('My Title');
        $fixture->setBic('My Title');
        $fixture->setTypeDeCompte('My Title');
        $fixture->setNomBanque('My Title');
        $fixture->setCommentaire('My Title');
        $fixture->setEtatDuCompte('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setInterlocuteur('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/society/rib/');
    }
}
