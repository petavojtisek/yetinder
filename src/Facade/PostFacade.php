<?php
namespace App\Facade;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Intl\Locale;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Intl\Countries;


class PostFacade
{

    /** @var PostRepository  */
    public PostRepository $postRepository;

    /** @var CommentRepository  */
   public CommentRepository $commentRepository;

   /** @var EntityManagerInterface */
   public EntityManagerInterface $entityManager;

   /** @var Security  */
   private Security $security;

    public function __construct(PostRepository $postRepository,
                                CommentRepository $commentRepository,
                                Security $security,
                                EntityManagerInterface $entityManager


    )
    {
       $this->commentRepository = $commentRepository;
       $this->postRepository = $postRepository;
       $this->security = $security;
       $this->entityManager = $entityManager;




    }


    private function getUser(){
        return $this->security->getUser();
    }

    private function loadCommentsByUser(){
        $exists = false;

        $list =  $this->commentRepository->findBy(['author'=>$this->getUser()]);
        if($list){
            foreach ( $list as $collection){
                $exists[$collection->getPost()->getId()] = $collection->getPost()->getId();
            }
        }

        return $exists;
    }

    public function getTopPost(){
        return $this->postRepository->findBy([], ['points'=>'desc'],10,0);
    }

    /**
     * @param $user
     * @return mixed|null
     */
    public function getSurprisePost($user, $locale): mixed {

        $country = $this->getCountryFromLocale($locale);

        /** @var Post $s */
        $s = $this->postRepository->getSurprisePost($user,$country);
        return $s;
    }

    private function getCountryFromLocale($locale){

        $countryCode = Locale::parseLocale(Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']))['region'];
        if($countryCode){
            return  $countryCode;
        }

        $country = 'CZ';
        switch (strtolower($locale)){
            case 'en':
                $country = "GB";
            case 'de':
                $country = "DE";
            case 'fr':
                $country = "FR";
        }

        return $country;
    }

    public function getPostListTemplateData(int $page){

        $latestPosts =  $this->postRepository->findLatest($page);

        $userId = $this->getUser()?->getId();
        if(!empty($latestPosts->getNumResults())) {
            return [
                'posts' => $latestPosts->getResults(),
                'paginator' => $latestPosts,
                'voted' => $this->loadCommentsByUser(),
                'userId' => $userId
            ];
        }

    }


    public function commentPost($post, $star){


        $exists = $this->commentRepository->findOneBy(['author'=>$this->getUser(), 'post'=>$post]);

        if ($post->getAuthor() === $this->getUser()) {
           return false;
        }

        if($exists){
            return false;
        }

        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $comment->setPoints($star);

        $post->addComment($comment);
        $post->increasePoints($star);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return true;
    }


    /**
     * @param string $groupFormat
     * @param int $daysInterval
     * @return array
     */
    public function getStats(string $groupFormat, \DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo,  int $topPositions) : array{
       $res = $this->commentRepository->getStats($groupFormat,$dateFrom, $dateTo ,$topPositions);

        if($res){
            return $this->formatData($res);
        }

       return [];
    }


    /**
     * @param array $res
     * @return array
     */
    private function formatData(array $res): array
    {


        $data = [];
        $baseStruct = ['max'=>0, 'labels'=>[],'dataSet'=>[]];
        foreach ($res as $resData){
            $resData = (object) $resData;
            if(!isset($data[$resData->dateUnit])) {
                $data[$resData->dateUnit] = $baseStruct;
                $data[$resData->dateUnit]['labels'][] =  $resData->dateUnit;
            }

            $data[$resData->dateUnit]['max'] =  max( $data[$resData->dateUnit]['max'],$resData->rewardedPoints );
            $data[$resData->dateUnit]['dataSet'][] =  ['label'=> $resData->name, 'data'=>[$resData->rewardedPoints]];
        }

        foreach($data as $index=>$graphData){
            $data[$index]['labels']=json_encode($graphData['labels']);
            $data[$index]['dataSet']=json_encode($graphData['dataSet']);

        }



        return $data;
    }





}