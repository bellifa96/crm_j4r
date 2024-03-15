<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{

    private $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getUsersByRole($role)
    {
        return $this->createQueryBuilder('u')
            ->andWhere(':role MEMBER OF u.roles')
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
    }

    public function getEmailsForRoleDevUsers()
    {
        $userRepository = $this->entityManager->getRepository(User::class);

        // Create a query to get users with a role that contains "ROLE_DEV"
        $query = $userRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_DEV%')
            ->getQuery();

        // Execute the query and get the results
        $roleDevUsers = $query->getResult();

        // Extract email addresses from the user entities
        $emails = [];
        foreach ($roleDevUsers as $user) {
            if ($user instanceof UserInterface) {
                $emails[] = $user->getEmail();
            }
        }

        return $emails;
    }
    public function getEmailsForRoleConducteurTraveaux()
    {
        $userRepository = $this->entityManager->getRepository(User::class);

        // Create a query to get users with a role that contains "ROLE_CONDUCTURE_TRAVEAUX"
        $query = $userRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_CONDUCTURE_TRAVEAUX%')
            ->getQuery();

        // Execute the query and get the results
       

        // Extract email addresses from the user entities
       

        return $query;
    }

    public function findByIdUser($id)
    {
       return  $this->_em->createQueryBuilder()
        ->select('ch')
        ->from(User::class, 'ch')
        ->andWhere('ch.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();

    }

 
}
