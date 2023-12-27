<?php
// src/Repository/ArticleRepository.php

namespace App\Repository\Depot;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;

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
        return true;
    }

    public function findAllbyIdDepot($iddepotId)
    {

        $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.idarticles', 'article.article', 'article.designation', 'article.poids', 'article.qtetotale', 'article.qtedispo', 'article.qtesortie', 'article.qtereserve', 'article.qtetransit')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->setParameter('depotId', $iddepotId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $depotsbyid;
    }

    public function findAll_article_désignation_byIdDepot($iddepotId,$type=1)
    {

        if($type==1){
            $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.idarticles', 'article.article', 'article.designation', 'article.poids')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->andWhere('article.location = 1')
            ->setParameter('depotId', $iddepotId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }else{
            $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.idarticles', 'article.article', 'article.designation', 'article.poids')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->andWhere('article.vente = 1')
            ->setParameter('depotId', $iddepotId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }
    

        return $depotsbyid;
    }
    
    public function findAll_article_bydésignation($iddepotId, $article)
    {

        $query = $this->_em->createQueryBuilder()
            ->select('article.idarticles', 'article.article', 'article.designation', 'article.poids')
            ->from(Articles::class, 'article')
            ->where('article.depot = :depotId')
            ->andWhere('article.article = :articleD')
            ->setParameter('depotId', $iddepotId)
            ->setParameter('articleD', $article)
            ->getQuery();

        $articles = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $articles;
    }

    public function findAllbyIdDepotoptimiser($iddepotId)
    {

        $depotsbyid = $this->_em->createQueryBuilder()
            ->select('article.idarticles', 'article.prixloc', 'article.prixvente', 'article.article', 'article.designation', 'article.poids', 'article.qtetotale', 'article.qtedispo', 'article.qtesortie', 'article.qtereserve', 'article.qtetransit')
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
    public function updateQteReserverById(string $article, int $newQteSortie, Depot $iddepot): void
    {
        $qb = $this->createQueryBuilder('c')
            ->update()
            ->set('c.qtereserve', 'c.qtereserve + :newQteSortie')
            ->where('c.article = :article')
            ->andWhere('c.depot = :iddepot') // Use the correct field name representing the association
            ->setParameter('newQteSortie', $newQteSortie)
            ->setParameter('article', $article)
            ->setParameter('iddepot', $iddepot);

        $qb->getQuery()->execute();
        $this->getEntityManager()->flush();

    }
}
