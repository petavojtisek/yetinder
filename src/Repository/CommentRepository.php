<?php

namespace App\Repository;


use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @method Comment|null findOneByAuthorId(int $author)
 *
 * @template-extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{

    private Connection $connection;
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Comment::class);
        $this->entityManager = $entityManager;
    }


    public function getStats(string $groupFormat, \DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo,  int $topPositions){


        $connection = $this->entityManager->getConnection();



        $qSql = ' select * from (
                            SELECT  post_id ,rewardedPoints, dateUnit, name
                             ,(@num:=if(@group = `dateUnit`  , @num +1, if(@group := `dateUnit` , @rpoins:=0, 1))) tmp_group_counter 
                            ,(@rpoins:=if(@points = `rewardedPoints`  , @rpoins,  if(@points := `rewardedPoints` , @rpoins +1, 0)   )) position  
                            FROM 
                            (
                            
                            select sum(w.points) as rewardedPoints, post_id, DATE_FORMAT(w.published_at,:format) as dateUnit, p.name 
                            from wjs_comment w
                            join wjs_post p on  p.id = w.post_id
                            where w.published_at >= :dateStart and  w.published_at <= :dateEnd
                            group by post_id, DATE_FORMAT(w.published_at,:format)  
                            ORDER BY dateUnit DESC, rewardedPoints DESC 
                            )t
                            CROSS JOIN (select @num:=0, @rpoins:=0, @group:=null, @points:=null) c
                            )z
                            where position<'.$topPositions.'
                            order by dateUnit DESC, rewardedPoints DESC
                       ';



        return $connection->fetchAllAssociative($qSql,
            [   'format'=>$groupFormat,
                'dateStart'=>$dateFrom->format("Y-m-d H:i:s"),
                'dateEnd'=>$dateTo->format("Y-m-d H:i:s"),
            ]);
    }

}