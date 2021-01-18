<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;

use App\Form\PostType;

class AdminController extends AbstractController
{
    /**
	* @Route("/admin/post", name="admin_post")
	*
	*/
	public function adminPost(){
		//1 : Récupérer tous les posts
		$repo = $this -> getDoctrine() -> getRepository(Post::class);
		$posts = $repo -> findAll();

		//2 : Afficher dans une vue
		return $this -> render('admin/post_list.html.twig', ['posts' => $posts]);
	}

	/**
	* @Route("/admin/post/add", name="admin_post_add")
	*
	*/
	public function adminPostAdd(Request $request){
		$manager =$this -> getDoctrine() -> getManager();
		$post = new Post; // objet vide de l'entity Post.

		// formulaire...
		$form = $this -> createForm(PostType::class, $post);

		// traitement des infos du formulaire
		$form -> handleRequest($request); // lier définitivement le $post aux infos du formulaire (récupère les donnée saisies en $_Post)

		if($form -> isSubmitted() && $form -> isValid()){
			$manager -> persist($post); // Enregistre le post dans le system
			$post -> setRegisterDate(new \DateTime('now'));
			$post -> setUser('1');
			//post -> setUser($this -> getUser());
			$post -> uploadFile();
			$manager -> flush(); // Exécute toutes les requêtes en attentes.
			$this -> addFlash('success', 'Le post N°' . $post -> getId()  . ' a bien été enregistré');
			return $this -> redirectToRoute('admin_post');
		}
		return $this -> render('admin/post_form.html.twig', [
			'postForm' => $form -> createView()


		]);


	}

	/**
	* @Route("/admin/post/delete/{id}", name="admin_post_delete")
	*
	*/
	public function adminPostDelete($id){
		
		//1 : Manager
		$manager = $this -> getDoctrine() -> getManager();
		//2 : Récupérer l'entrée à suppr
		$post = $manager -> find(Post::class, $id);
		//3 : Suppr
		$manager -> remove($post);
		$manager -> flush();
		//4 : Message
		$this -> addFlash('success', 'Le post N°' . $id . ' a bien été supprimé !');
		//5 : Redirection
		return $this -> redirectToRoute('admin_post');
	}

	/**
	* @Route("/admin/post/update/{id}", name="admin_post_update")
	*
	*/
	public function adminPostUpdate($id, Request $request){
		//1 : Récupérer le manager
		$manager = $this -> getDoctrine() -> getManager();
		//2 : Récupérer l'objet
		$post = $manager -> find(Post::class, $id);
		$form = $this -> createForm(PostType::class, $post);
		//Notre objet hydrate le formulaire
		$form -> handleRequest($request);
		
		if($form -> isSubmitted() && $form -> isValid()){
			//3 : Modifier (Formulaire)
		//$post -> setTitle('Nouveax titre'); //test FORMULAIRE...
		$manager -> persist($post);
		if($post -> getFile()){
			$post -> removeFile();
			$post -> uploadFile();
		}

		$manager -> flush();
		//4 : Message
		$this -> addFlash('success', 'Le Post Nouveax N°' . $id . ' a bien été modifié !');
		return $this -> redirectToRoute('admin_post');
		}
		//5 : Vue 
		return $this -> render('admin/post_form.html.twig', ['postForm' => $form -> createView()]);
		// test : localhost:8000/admin/post/update/id

		}
}
