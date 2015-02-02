<?php
/*
NOTE : THIS PAGE HAS NEVER BEEN USED IN THE PROJECT, IT'S ONLY A TEST PAGE CREATED TO UNDERSTAND HOW IT WORKS.
TO CREATE A POKEMON, I USE THE FILE DASHBOARD.PHP
*/
/** @var \Doctrine\ORM\EntityManager $em */
$em = require __DIR__ . '/bootstrap.php';

use Xusifob\PokemonBattle\Pokemon;

/** @var \Doctrine\ORM\EntityRepository $trainerRepo */
$trainerRepo = $em->getRepository('Xusifob\PokemonBattle\Trainer');

/** @var \Xusifob\PokemonBattle\Trainer $trainer */
$trainer = $trainerRepo->find(1);

/** @var Pokemon $pokemon */
$pokemon = new Pokemon();

$pokemon
    ->setName('Pokemon')
    ->setHP(100)
    ->setTrainer($trainer)
    ->setType(Pokemon::TYPE_FIRE)
;

// I register the pokemon
$em->persist($pokemon);

// Add it to the database
$em->flush();
