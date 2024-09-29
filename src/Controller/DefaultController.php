<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\CommentRepository;

use App\Repository\TagRepository;
use App\Utils\ImageResizeService;
use Composer\Autoload\ClassLoader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;


#[Route('/')]
final class DefaultController extends AbstractController
{

    #[Route('/list', name: 'list', defaults: ['page' => '1', '_format' => 'html'], methods: ['GET'])]
    #[Route('/list/page/{page<[1-9]\d{0,8}>}', name: 'list_paginated', defaults: ['_format' => 'html'], methods: ['GET'])]
    #[Cache(smaxage: 10)]
    public function index(Environment $twig, Request $request, int $page, string $_format,  \App\Facade\PostFacade $postFacade): Response
    {

        $latestPostsData = $postFacade->getPostListTemplateData($page);
        $latestPostsData['layout']='full';
        return $this->render('default/list.html.twig', $latestPostsData);

    }




    #[Route('/new', name: 'new_post', methods: ['GET', 'POST'])]
    //#[MapEntity(mapping: ['postSlug' => 'slug'])] Post $post,
    public function postNew(
        #[CurrentUser] User $user,
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        ImageResizeService $resizeService
    ): Response
    {
        $post = new Post();
        $post->setAuthor($user);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //upload image todo
            //dd($form['imageFile']->getData());
            $fileUploaded = $form['imageFile']->getData();

            if($fileUploaded instanceof UploadedFile) {
                $imageName = $this->uploadTmpImage($form['imageFile']->getData(), $slugger, $resizeService);
                $post->setImage($imageName);
            }

            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'post.created_successfully');
            //$eventDispatcher->dispatch(new CommentCreatedEvent($comment));
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form,

        ]);
    }


    /**
     * @param UploadedFile $uploadedFile
     * @param SluggerInterface $slugger
     * @return string
     */
    private function uploadTmpImage(UploadedFile $uploadedFile, SluggerInterface $slugger, ImageResizeService $resizeService) : string
    {

        $destination = $this->getParameter('kernel.project_dir').'/public/uploads/image';
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $newFilename = $slugger->slug($originalFilename)->lower().'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );


        $source = $this->getParameter('kernel.project_dir').'/public/uploads/image/'.$newFilename;
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads/image/small_'.$newFilename;

        //try create thumb image
        try {
            $resizeService->imageResize($source, $destination, 128, 128, 100);
        }catch (\Exception $e){
                //log no small image upload
        }

        return $newFilename;
    }

    #[Route('/comment/{postSlug}/{star<\d+>}', name: 'comment_new', methods: ['POST', "GET"])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function commentNew(
        #[CurrentUser] User $user,
        Request $request,
        #[MapEntity(mapping: ['postSlug' => 'slug'])] Post $post,
        int $star,
        EventDispatcherInterface $eventDispatcher,
        EntityManagerInterface $entityManager,
        CommentRepository $commentRepository
    ): Response
    {


        $error = false;
        $submittedToken = $request->query->get('token');
        if (! $this->isCsrfTokenValid('comment-item', $submittedToken)) {
            $error = true;
        }

        $exists = $commentRepository->findOneBy(['author'=>$this->getUser(), 'post'=>$post]);


        if ($post->getAuthor() === $this->getUser()) {
            $this->addFlash('danger','error.vote.author');
            $error = true;
        }

        if($exists){
            $this->addFlash('error','error.vote.multiple');
            $error = true;
        }

        if(!$error) {
            $comment = new Comment();
            $comment->setAuthor($user);
            $comment->setPoints($star);
            $post->addComment($comment);
            $post->increasePoints($star);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success','comment.voted.success');
        }
        return $this->redirectToRoute('list', [],Response::HTTP_SEE_OTHER);
    }





}