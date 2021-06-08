<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture 
{
  private $passwordEncoder;
  public function __construct(UserPasswordEncoderInterface $passwordEncoder)
  {
    $this->passwordEncoder = $passwordEncoder;
  }
public function load(ObjectManager $Manager)
{
    $this->loadUsers($Manager);
    $this->loadPosts($Manager);
}
public function loadPosts(ObjectManager $Manager)
{
  //nouvelle instance
  $slugify = new Slugify();
  //generer 20 fake post
  for($i =0;$i <20;$i++){
  $post = new Post();
  $post->setTitle('this my title number'.rand(0,100));
  $post->setBody('this my body number'.rand(0,100));
  $post->setTime(new \DateTime());
  $post->setUser($this->getReference('oubeid'));
  $post->setSlug($slugify->slugify($post->getTitle()));
  $Manager->persist($post);
  
}
$Manager->flush();
}
public function loadUsers(ObjectManager $Manager)
{
 
  
  
  $user = new User();
  $user->setUsername('oubeid123');
  $user->setFullname('kefi oubeid');
  $user->setEmail('oubeid@gmail.com');
  $user->setPassword(
    $this->passwordEncoder->encodePassword(
      $user,'oubei123'
    )
    );
    $this->addReference('oubeid',$user);
  $Manager->persist($user);
  $Manager->flush();
}


}