<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    
	/**
	* @Route("/bonjour")
	* localhost:8000/bonjour
	*www.monblog.com/bonjour
	*/
	public function bonjour(){
		echo'Bonjour tout le monde !';
	}


	/**
	* @Route("/hello", name="hello")
	* localhost:8000/hello
	*/
	public function hello(){
		return new Response('<h1>Bienvenue</h1>');
	}

	/**
	* @Route("/hola/{prenom}")
	*
	*/
	public function hola($prenom){
		return new Response('Hola ' . $prenom . ' !');
	}
	// test : localhost:8000/hola/Yakine
	// test : localhost:8000/hola/Thomas
	// test : localhost:8000/hola/dark


	/**
	* @Route("/ciao/{prenom}")
	*
	*/
	public function ciao($prenom){
		return $this -> render('user/ciao.html.twig', array(
			'prenom' => $prenom ));
	}


	/**
	* @Route("/redirect")
	*
	*/
	public function redirect2(){
		return $this -> redirectToRoute('hello');
	}
	//test : localhost:8000\redirect --> Hello World !
	


	/**
	*@Route("/message", name="message")
	*
	*/
	public function message(){
		$this -> addFlash('success', 'Félicitations vous êtes inscrit !');
		$this -> addFlash('errors', 'Le post numéro 8 
			n\'existe pas !');

			return $this -> render('user/message.html.twig',
				array());
	}

}
