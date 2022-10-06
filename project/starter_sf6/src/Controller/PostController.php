<?php

namespace App\Controller;
//namespace App\Form;

//use Doctrine\DBAL\Types\TextType;
use App\Entity\Posts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use function Sodium\add;

class PostController extends AbstractController
{
    #[Route('/post/create', name: 'app_post_create')]
    public function createPost(ManagerRegistry $doctrine, Request $request): Response
    {

        $post = new Posts();
        $post->setEnable(true);

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('dateCreated', DateType::class)
            ->add('enable', CheckboxType::class)
            ->add('save', SubmitType::class, array('label' => 'enregistrer'))
            ->getForm();

        $form->handleRequest($request); // hydratation du form
        if ($form->isSubmitted() && $form->isValid()) { // test si le formulaire a été soumis et s'il est valide
            $em = $doctrine->getManager(); // on récupère la gestion des entités
            $em->persist($post); // on effectue les mise à jours internes
            $em->flush(); // on effectue la mise à jour vers la base de données
            return $this->redirectToRoute('app_home', ['id' => $post->getId()]); // on redirige vers la route show_task avec l'id du post créé ou modifié
        }

        return $this->render('post/createPost.html.twig', [
            'postType' => $form->createView(),
        ]);

    }

    #[Route('/post/update/{post}', name: 'app_post_update')]
    public function updatePost(Request $request, ManagerRegistry $doctrine, Posts $post): Response
    {
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('dateCreated', DateType::class)
            ->add('enable', CheckboxType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request); // hydratation du form
        if($form->isSubmitted() && $form->isValid() && $form->title){ // test si le formulaire a été soumis et s'il est valide
            $em = $doctrine->getManager(); // on récupère la gestion des entités
            $em->persist($post); // on effectue les mise à jours internes
            $em->flush(); // on effectue la mise à jour vers la base de données
//            return $this->redirectToRoute('show_post', ['id' => $post->getId()]); // on redirige vers la route show_task avec l'id du post créé ou modifié
        }

        return $this->render('post/updatePost.html.twig', [
            'postType' => $form->createView()
        ]);
    }

    #[Route('/post/all', name: 'app_posts')]
    public function getAllPosts(ManagerRegistry $doctrine){

        $posts = $doctrine->getRepository(Posts::class)->findAll();
        $em = $doctrine->getManager();
        return $this->render('posts.html.twig',
            ['posts'=> $posts]);
    }

    #[Route('/post/delete/{id}', name: 'app_post_delete')]
    public function deletePost(ManagerRegistry $doctrine, int $id)
    {

        $post = $doctrine->getRepository(Posts::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('app_posts');

    }

    #[Route('/post/view/{id}', name: 'app_post_view')]
    public function viewPost(ManagerRegistry $doctrine, int $id): Response
    {
        $postType = $doctrine->getRepository(Posts::class)->find($id);
        return $this->render('view.html.twig',
            ['postType'=> $postType]);
    }


}