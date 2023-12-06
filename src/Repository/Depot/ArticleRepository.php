<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Depot\Articles;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * Depot Repository c'est la partie DAO dans la couche trois Tiers pour la communication avec la base de donne -> couche service -> couche web (Controller)
 */

class ArticleRepository extends ServiceEntityRepository
{




    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function findPublishedArticles()
    {
    }
    // add Articles 
    public function add(Articles $articles)
    {
        $this->_em->persist($articles);

        $this->_em->flush();
    }

    public function findAllbyIdDepot($iddepotId)
    {

        $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.article', 'article.designation', 'article.poids', 'article.qtetotale', 'article.qtedispo', 'article.qtesortie', 'article.qtereserve', 'article.qtetransit')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->setParameter('depotId', $iddepotId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $depotsbyid;
    }

    public function findAllbyIdDepotoptimiser($iddepotId)
    {

        $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.article', 'article.designation', 'article.poids', 'article.qtetotale', 'article.qtedispo', 'article.qtesortie', 'article.qtereserve', 'article.qtetransit')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->setParameter('depotId', $iddepotId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $depotsbyid;
    }


   

    public function addAll($articles)
    {
        $em = $this->getEntityManager();

        foreach ($articles as $article) {
            $em->persist($article);
        }

        $em->flush();
    }
}
