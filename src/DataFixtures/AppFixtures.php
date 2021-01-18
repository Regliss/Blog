<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) // injection de dépendance
    {
     
    	for($i = 1; $i <= 2; $i++){
    		$user = new User;

    		$user -> setUsername('user' . $i);
    		$user -> setPassword('123456');
    		$user -> setEmail('user' . $i . '@gmail.com');
    		$manager -> persist($user);
    		// INSERT INTO USER () VALUES ()
    	}


        $manager->flush();

        for($j=1;$j<=20;$j++){
        	$post = new Post;

        	$post -> setTitle('Article N°' . $j);
        	$post -> setUser(1);
        	$post -> setContent('Lorem nfoeoanfioz fnezionfezo nfioeznofzn nfoeznfozen fnezionfezon');
        	$post -> setImage('image' . rand(1,3) . '.jpg');
        	$post -> setCategory('category' . rand(1, 3));
        	$post -> setRegisterDate(new \DateTime('now'));
        	$manager -> persist($post);

        	for($x=1; $x<=rand(1, 10); $x++){
        		$comment = new Comment;
        		$comment -> setContent('Lorem nfoeoanfioz fnezionfezo nfioeznofzn nfoeznfozen fnezionfezon');
        		$comment -> setPost($j);
        		$comment -> setPseudo('user' . rand(1,10));
        		$comment -> setRegisterDate(new \DateTime('now'));
        		$manager -> persist($comment);
        	}
        }
        $manager->flush();

    }
}
