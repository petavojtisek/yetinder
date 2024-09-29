<?php

namespace App\Controller;



use App\Entity\Post;
use App\Facade\PostFacade;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;


final class HomeController extends AbstractController
{

    //#[Route('/', name: 'homepage')]
    public function index(Request $request, PostFacade $postFacade): Response
    {
        $list = $postFacade->getTopPost();
        $params = ['posts'=>$list, 'surprise'=>false];

        $locale = $request->getLocale();
        if ($surprise = $postFacade->getSurprisePost($this->getUser(), $locale)){
            $params['surprise'] = $surprise;
        }


        return $this->render('default/intro.html.twig', $params);
    }


    #[Route('/ajax', name: 'homepage_ajax')]
    public function loadListAjax(PostFacade $postfacade){
        $latestPosts = $postfacade->getTopPost();
        $posts = $this->render('post/_post_list.html.twig',['posts'=>$latestPosts, 'type'=>'hp'] );
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($posts->getContent()));
        return $response;
    }


    #[Route('/comment/ajax/{postSlug}/{star<\d+>}', name: 'comment_new_ajax')]
    #[IsGranted('IS_AUTHENTICATED')]
    public function commentAjax(
         Request $request,
         #[MapEntity(mapping: ['postSlug' => 'slug'])] Post $post,
         int $star,
        PostFacade $postFacade,
        TranslatorInterface $translator
    ) : ?Response {


        $submittedToken = $request->query->get('token');
        $res = false;
        if ($this->isCsrfTokenValid('comment-item', $submittedToken)) {
            $res = $postFacade->commentPost($post,$star);
        }


        $status = 'success';
        $message =$translator->trans('comment.voted.success');

        $locale = $request->getLocale();
        if ($surprise = $postFacade->getSurprisePost($this->getUser(), $locale)){
            $posts = $this->render('post/_post_item.html.twig', ['post' => $surprise, 'type' => 'card']);
        }

        if(!$res){
            $message = $translator->trans('comment.already.voted');
            $status = 'error';
        }

        $payload = ['status'=>$status, 'message'=>$message];
        if(isset($posts)){
            $payload['post'] = $posts->getContent();
        }


        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($payload));
        return $response;

    }



}