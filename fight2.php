<?php

/** @var \Doctrine\ORM\EntityManager $em */
$em = require __DIR__ . '/_header_connect.php';

use Xusifob\PokemonBattle\Pokemon;

$error = NULL;
/** @var \Doctrine\ORM\EntityRepository $PokemonRepo */
$PokemonRepo = $em->getRepository('Xusifob\PokemonBattle\Pokemon');

/** @var \Doctrine\ORM\EntityRepository $trainerRepo */
$trainerRepo = $em->getRepository('Xusifob\PokemonBattle\Trainer');

if(isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        /** @var \Xusifob\PokemonBattle\Trainer $trainer */
        $trainer = $trainerRepo->find($_SESSION['trainer']);
        /** @var \Xusifob\PokemonBattle\Pokemon $pokemon1 */
        $pokemon1 = $PokemonRepo->findOneBy([
            'trainer' => $trainer,
        ]);
        /** @var \Xusifob\PokemonBattle\Pokemon $pokemon2 */
        $pokemon2 = $PokemonRepo->find($_GET['id']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    // If the pokemon exists
    if (!isset($pokemon1) || NULL === $pokemon1 || !isset($pokemon2) || NULL === $pokemon2) {
        header('Location:dashboard.php');
    } else {    // I check if they can fight
        $lastFight = $pokemon1->getLastfight();
        if ($lastFight > time() - 6 * 3600)
            header('Location:dashboard.php');
        else{
            // Choose randomly the value of the attack
            $attack = rand(10,20);
            // I check the type for the attack
            if($pokemon1->getType() == Pokemon::TYPE_FIRE && $pokemon2->getType() == Pokemon::TYPE_PLANT)
                $attack = $attack*1.5;
            elseif($pokemon1->getType() == Pokemon::TYPE_FIRE && $pokemon2->getType() == Pokemon::TYPE_WATER)
                $attack = $attack/2;

            // I remove the hp to the other pokemon
            try {
                $pokemon2->removeHP($attack);
                $pokemon1->setLastfight(time());
                $em->flush();
            }
            catch(Exception $e){
                $error = $e->getMessage();
            }
        }
    }

}
else
    header('Location:dashboard.php');

// Display the model
echo $twig ->render('fight2.html.twig',[
    'pokemon1' => $pokemon1,
    'pokemon2' => $pokemon2,
    'error' => $error,
    'attack' => $attack,
]);
