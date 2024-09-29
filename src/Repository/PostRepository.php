<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use App\Facade\PostFacade;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\CoalesceExpression;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\u;

/**
 * @method Post|null findOneByTitle(string $postTitle)
 *
 * @template-extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{

    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry,    EntityManagerInterface $entityManager)
    {

        parent::__construct($registry, Post::class);
        $this->entityManager = $entityManager;
    }


    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('a')
            ->innerJoin('p.author', 'a')
            ->where('p.publishedAt <= :now')
            ->orderBy('p.publishedAt', 'DESC')
            ->setParameter('now', new \DateTime())
        ;

        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @return Post[]
     */
    public function findBySearchQuery(string $query, int $limit = Paginator::PAGE_SIZE): array
    {
        $searchTerms = $this->extractSearchTerms($query);

        if (0 === \count($searchTerms)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($searchTerms as $key => $term) {
            $queryBuilder
                ->orWhere('p.title LIKE :t_'.$key)
                ->setParameter('t_'.$key, '%'.$term.'%')
            ;
        }

        /** @var Post[] $result */
        $result = $queryBuilder
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }


    /**
     * @param $user
     * @return false|mixed
     */
    public function getSurprisePost(?User $user, $country){

        $com = $this->entityManager->getRepository('App\Entity\Comment');
        //nacteni jiz odhlasovanych postu
        $sub = $com->createQueryBuilder('c')
            ->select('c.id')
            ->andWhere('c.post = p.id')
            ->andWhere('c.author = :userId ');
        $sub->setParameter('userId', $user?->getId());


        $pGender = ($user?->getGender() == 'M') ? 'F': 'M';

        //nacteni postu kde nejsem autor a zaroven jsem nehlasoval
        $qb = $this->createQueryBuilder('p')
                ->addSelect('CASE WHEN (p.country = :country) THEN 1 ELSE 0 END AS HIDDEN mainSort')
                ->addSelect('CASE WHEN (p.gender = :gender) THEN 1 ELSE 0 END AS HIDDEN genderSort')
                ->setMaxResults(1)
                ->where('p.author != :userId')
                ->setParameter('country', $country)
                ->setParameter('gender', $pGender)
                ->setParameter('userId', $user?->getId())
                ->orderBy('genderSort DESC , mainSort DESC, RAND()');

        $qb->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())));
        $res = $qb->getQuery()->getResult();

        if($res and !empty($res)){
            return $res[0];
        }

        return false;



    }

    public function addPoints($id, $points){

      /*
        $em = $this->getDoctrine()->getManager();
        $em = $this->createQueryBuilder();
        $query = $em->createQuery(
            'UPDATE models\Post p
             SET p.points = COALESCE(p.points,0)+:points'
              WHERE p.id = :id
        )->setParameter('points', $points);
        ->setParameter('id', $id);
        $query->execute();


       /*
        $q = $this->createQueryBuilder()
            ->update('models\Post', 'p')
            ->set('p.points', COALESCE(p.points,0)+:points' )
            ->where('p.id = ?1')
            ->setParameter(1, $points)
            ->getQuery();
         $q->execute();
       */
    }


    /**
     * Transforms the search string into an array of search terms.
     *
     * @return string[]
     */
    private function extractSearchTerms(string $searchQuery): array
    {
        $terms = array_unique(u($searchQuery)->replaceMatches('/[[:space:]]+/', ' ')->trim()->split(' '));

        // ignore the search terms that are too short
        return array_filter($terms, static function ($term) {
            return 2 <= $term->length();
        });
    }
}
