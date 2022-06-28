<?php

namespace App\Test\Controller\Affaire;

use App\Entity\Affaire\Transport;
use App\Repository\Affaire\TransportRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransportControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TransportRepository $repository;
    private string $path = '/affaire/transport/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Transport::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transport index');

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
            'transport[codeChantierJ4R]' => 'Testing',
            'transport[codeChantierLayher]' => 'Testing',
            'transport[referenceCommande]' => 'Testing',
            'transport[codeIBM]' => 'Testing',
            'transport[codeERP]' => 'Testing',
            'transport[nCommande]' => 'Testing',
            'transport[typeDeTransport]' => 'Testing',
            'transport[typeDeVehicule]' => 'Testing',
            'transport[tonnageCommandé]' => 'Testing',
            'transport[tonnagePrepare]' => 'Testing',
            'transport[tonnageLivre]' => 'Testing',
            'transport[prix]' => 'Testing',
            'transport[montantDeLaCourse]' => 'Testing',
            'transport[adresseEnlevement]' => 'Testing',
            'transport[dateDEnlevementDemande]' => 'Testing',
            'transport[instructionEnlevementConducteur]' => 'Testing',
            'transport[adresseLivraison]' => 'Testing',
            'transport[dateLivraisonDemande]' => 'Testing',
            'transport[referenceLivraison]' => 'Testing',
            'transport[instructionLivraisonConducteur]' => 'Testing',
            'transport[donneurDOrdre]' => 'Testing',
            'transport[ConducteurDeTravaux]' => 'Testing',
            'transport[sousTraitantPrincipal]' => 'Testing',
            'transport[chauffeur]' => 'Testing',
            'transport[transporteur]' => 'Testing',
            'transport[contactEnlevement]' => 'Testing',
            'transport[contactLivraison]' => 'Testing',
        ]);

        self::assertResponseRedirects('/affaire/transport/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transport();
        $fixture->setCodeChantierJ4R('My Title');
        $fixture->setCodeChantierLayher('My Title');
        $fixture->setReferenceCommande('My Title');
        $fixture->setCodeIBM('My Title');
        $fixture->setCodeERP('My Title');
        $fixture->setNCommande('My Title');
        $fixture->setTypeDeTransport('My Title');
        $fixture->setTypeDeVehicule('My Title');
        $fixture->setTonnageCommandé('My Title');
        $fixture->setTonnagePrepare('My Title');
        $fixture->setTonnageLivre('My Title');
        $fixture->setPrix('My Title');
        $fixture->setMontantDeLaCourse('My Title');
        $fixture->setAdresseEnlevement('My Title');
        $fixture->setDateDEnlevementDemande('My Title');
        $fixture->setInstructionEnlevementConducteur('My Title');
        $fixture->setAdresseLivraison('My Title');
        $fixture->setDateLivraisonDemande('My Title');
        $fixture->setReferenceLivraison('My Title');
        $fixture->setInstructionLivraisonConducteur('My Title');
        $fixture->setDonneurDOrdre('My Title');
        $fixture->setConducteurDeTravaux('My Title');
        $fixture->setSousTraitantPrincipal('My Title');
        $fixture->setChauffeur('My Title');
        $fixture->setTransporteur('My Title');
        $fixture->setContactEnlevement('My Title');
        $fixture->setContactLivraison('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transport');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transport();
        $fixture->setCodeChantierJ4R('My Title');
        $fixture->setCodeChantierLayher('My Title');
        $fixture->setReferenceCommande('My Title');
        $fixture->setCodeIBM('My Title');
        $fixture->setCodeERP('My Title');
        $fixture->setNCommande('My Title');
        $fixture->setTypeDeTransport('My Title');
        $fixture->setTypeDeVehicule('My Title');
        $fixture->setTonnageCommandé('My Title');
        $fixture->setTonnagePrepare('My Title');
        $fixture->setTonnageLivre('My Title');
        $fixture->setPrix('My Title');
        $fixture->setMontantDeLaCourse('My Title');
        $fixture->setAdresseEnlevement('My Title');
        $fixture->setDateDEnlevementDemande('My Title');
        $fixture->setInstructionEnlevementConducteur('My Title');
        $fixture->setAdresseLivraison('My Title');
        $fixture->setDateLivraisonDemande('My Title');
        $fixture->setReferenceLivraison('My Title');
        $fixture->setInstructionLivraisonConducteur('My Title');
        $fixture->setDonneurDOrdre('My Title');
        $fixture->setConducteurDeTravaux('My Title');
        $fixture->setSousTraitantPrincipal('My Title');
        $fixture->setChauffeur('My Title');
        $fixture->setTransporteur('My Title');
        $fixture->setContactEnlevement('My Title');
        $fixture->setContactLivraison('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'transport[codeChantierJ4R]' => 'Something New',
            'transport[codeChantierLayher]' => 'Something New',
            'transport[referenceCommande]' => 'Something New',
            'transport[codeIBM]' => 'Something New',
            'transport[codeERP]' => 'Something New',
            'transport[nCommande]' => 'Something New',
            'transport[typeDeTransport]' => 'Something New',
            'transport[typeDeVehicule]' => 'Something New',
            'transport[tonnageCommandé]' => 'Something New',
            'transport[tonnagePrepare]' => 'Something New',
            'transport[tonnageLivre]' => 'Something New',
            'transport[prix]' => 'Something New',
            'transport[montantDeLaCourse]' => 'Something New',
            'transport[adresseEnlevement]' => 'Something New',
            'transport[dateDEnlevementDemande]' => 'Something New',
            'transport[instructionEnlevementConducteur]' => 'Something New',
            'transport[adresseLivraison]' => 'Something New',
            'transport[dateLivraisonDemande]' => 'Something New',
            'transport[referenceLivraison]' => 'Something New',
            'transport[instructionLivraisonConducteur]' => 'Something New',
            'transport[donneurDOrdre]' => 'Something New',
            'transport[ConducteurDeTravaux]' => 'Something New',
            'transport[sousTraitantPrincipal]' => 'Something New',
            'transport[chauffeur]' => 'Something New',
            'transport[transporteur]' => 'Something New',
            'transport[contactEnlevement]' => 'Something New',
            'transport[contactLivraison]' => 'Something New',
        ]);

        self::assertResponseRedirects('/affaire/transport/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCodeChantierJ4R());
        self::assertSame('Something New', $fixture[0]->getCodeChantierLayher());
        self::assertSame('Something New', $fixture[0]->getReferenceCommande());
        self::assertSame('Something New', $fixture[0]->getCodeIBM());
        self::assertSame('Something New', $fixture[0]->getCodeERP());
        self::assertSame('Something New', $fixture[0]->getNCommande());
        self::assertSame('Something New', $fixture[0]->getTypeDeTransport());
        self::assertSame('Something New', $fixture[0]->getTypeDeVehicule());
        self::assertSame('Something New', $fixture[0]->getTonnageCommandé());
        self::assertSame('Something New', $fixture[0]->getTonnagePrepare());
        self::assertSame('Something New', $fixture[0]->getTonnageLivre());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getMontantDeLaCourse());
        self::assertSame('Something New', $fixture[0]->getAdresseEnlevement());
        self::assertSame('Something New', $fixture[0]->getDateDEnlevementDemande());
        self::assertSame('Something New', $fixture[0]->getInstructionEnlevementConducteur());
        self::assertSame('Something New', $fixture[0]->getAdresseLivraison());
        self::assertSame('Something New', $fixture[0]->getDateLivraisonDemande());
        self::assertSame('Something New', $fixture[0]->getReferenceLivraison());
        self::assertSame('Something New', $fixture[0]->getInstructionLivraisonConducteur());
        self::assertSame('Something New', $fixture[0]->getDonneurDOrdre());
        self::assertSame('Something New', $fixture[0]->getConducteurDeTravaux());
        self::assertSame('Something New', $fixture[0]->getSousTraitantPrincipal());
        self::assertSame('Something New', $fixture[0]->getChauffeur());
        self::assertSame('Something New', $fixture[0]->getTransporteur());
        self::assertSame('Something New', $fixture[0]->getContactEnlevement());
        self::assertSame('Something New', $fixture[0]->getContactLivraison());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Transport();
        $fixture->setCodeChantierJ4R('My Title');
        $fixture->setCodeChantierLayher('My Title');
        $fixture->setReferenceCommande('My Title');
        $fixture->setCodeIBM('My Title');
        $fixture->setCodeERP('My Title');
        $fixture->setNCommande('My Title');
        $fixture->setTypeDeTransport('My Title');
        $fixture->setTypeDeVehicule('My Title');
        $fixture->setTonnageCommandé('My Title');
        $fixture->setTonnagePrepare('My Title');
        $fixture->setTonnageLivre('My Title');
        $fixture->setPrix('My Title');
        $fixture->setMontantDeLaCourse('My Title');
        $fixture->setAdresseEnlevement('My Title');
        $fixture->setDateDEnlevementDemande('My Title');
        $fixture->setInstructionEnlevementConducteur('My Title');
        $fixture->setAdresseLivraison('My Title');
        $fixture->setDateLivraisonDemande('My Title');
        $fixture->setReferenceLivraison('My Title');
        $fixture->setInstructionLivraisonConducteur('My Title');
        $fixture->setDonneurDOrdre('My Title');
        $fixture->setConducteurDeTravaux('My Title');
        $fixture->setSousTraitantPrincipal('My Title');
        $fixture->setChauffeur('My Title');
        $fixture->setTransporteur('My Title');
        $fixture->setContactEnlevement('My Title');
        $fixture->setContactLivraison('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/affaire/transport/');
    }
}
