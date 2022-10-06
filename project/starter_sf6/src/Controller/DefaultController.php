<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Form\RechercheType;
use App\Repository\PostsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[IsGranted("ROLE_USER")]
    #[Route('/default/post/create', name: 'app_default_newPost')]
    public function createPost(ManagerRegistry $doctrine, Request $request): Response
    {
        $user = $this->getUser();
        dump($user);
        $post = new Posts();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $doctrine->getManager(); // on récupère la gestion des entités
                $em->persist($post); // on effectue les mise à jours internes
                $em->flush(); // on effectue la mise à jour vers la base de données
                //return $this->redirectToRoute('app_home', ['id' => $post->getId()]); // on redirige vers la route show_task avec l'id du post créé ou modifié
            }
            //else {
            //    echo '<div class="alert alert-danger">moins de 20 caractères on a dit !</div>';
            //}
        }

        return $this->render('default/newpost.html.twig', [
            'creationForm' => $form->createView()
        ]);
    }

    #[Route('/default/post/update/id={id}', name: 'app_default_update')]
    public function updatePost(ManagerRegistry $doctrine, Request $request, Posts $id): Response
    {
        $form = $this->createForm(PostType::class, $id);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // test si le formulaire a été soumis et s'il est valide
            $em = $doctrine->getManager(); // on récupère la gestion des entités
            $em->persist($id); // on effectue les mise à jours internes
            $em->flush(); // on effectue la mise à jour vers la base de données
            //return $this->redirectToRoute('app_home', ['id' => $post->getId()]); // on redirige vers la route show_task avec l'id du post créé ou modifié
        }

        return $this->render('default/updatePost.html.twig', [
            'updateForm' => $form->createView()
        ]);

    }

    #[Route('/default/post/all', name: 'app_default_all')]
    public function AllPost(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Posts::class)->findAll();
        $em = $doctrine->getManager();
        return $this->render('default/listpost.html.twig', ['posts' => $posts]);
    }

    #[Route('/default/post/search/{word}', name: 'app_default_searchPost')]
    public function searchPost(PostsRepository $postsRepository, Request $request, string $word = null): Response
    {
        $posts = [];
        $form = $this->createForm(RechercheType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData()['search'];
            $posts = $postsRepository->search($word);
        }

        return $this->render('default/search.html.twig', [
            'searchForm' => $form->createView(),
            'posts' => $posts
        ]);
    }

}
