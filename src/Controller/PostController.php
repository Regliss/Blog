<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(){

    	//1 : Récupérer les infos (les posts, les catégories, les 3 derniers posts)

    	$repository = $this -> getDoctrine() -> 
    	getRepository(Post::class);

    	$posts = $repository -> findAll();
    	$categories = $repository -> findAllCategories2();

    


    	// SELECT * FROM post ORDER BY registerDate DESC LIMIT 0, 3
    	//2 : Afficher la vue en transmettant la data
    	return $this -> render('post/index.html.twig', array(
    		'posts' => $posts,
    		'categories' => $categories
    	));
    }


    /**
	* @Route("/show/{id}", name="show")
	*
	*/
	public function show($id){
		//1 : Récupérer les infos du post
		$repo= $this -> getDoctrine() -> getRepository(Post::class);
		$post = $repo -> find($id);

		//2 : Afficher la vue avec les infos
		return $this -> render('post/show.html.twig', array(
			'post' => $post ));
	}


	/**
	* @Route("/category/{cat}", name="category")
	*
	*/
	public function category($cat){
		//1:Récupérer les posts de la catégories $cat
		$repo = $this -> getDoctrine() -> getRepository(Post::class);
		$posts = $repo -> findBy(['category' => $cat]);
		$categories = $repo -> findAllCategories();

		//2: Les afficher dans la vue
		return $this -> render('post/index.html.twig', array(
			'posts' => $posts,
			'categories' => $categories
		));
	}
	// test : localhost:8000/category/category1
	// test : localhost:8000/category/category2
	// test : localhost:8000/category/category3

}
