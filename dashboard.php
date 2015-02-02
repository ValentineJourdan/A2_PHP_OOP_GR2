<?php

/** @var \Doctrine\ORM\EntityManager $em */
$em = require __DIR__ . '/_header_connect.php';

use Xusifob\PokemonBattle\Pokemon;

// I set the vars to avoid errors
$error = NULL;
$delta = 0;
$fight = false;
$heal = false;
$dHeal = 0;

    /** @var \Doctrine\ORM\EntityRepository $PokemonRepo */
    $PokemonRepo = $em->getRepository('Xusifob\PokemonBattle\Pokemon');

    /** @var \Doctrine\ORM\EntityRepository $trainerRepo */
    $trainerRepo = $em->getRepository('Xusifob\PokemonBattle\Trainer');

    try{
        /** @var \Xusifob\PokemonBattle\Trainer $trainer */
        $trainer = $trainerRepo->find($_SESSION['trainer']);
    }
    catch(Exception $e){
        $error = $e->getMessage();
    }


    // Get the pokemon
    try {
        /** @var Pokemon $pokemon */
        $pokemon = $PokemonRepo->findOneBy([
            'trainer' => $trainer,
        ]);
    }
    catch(Exception $e){
        $error = $e->getMessage();
    }
    if(!isset($pokemon) || NULL === $pokemon){
        $pokemon = NULL;
    }
    // Calculate if he can fight or not
    else{
        $lastFight = $pokemon->getLastfight();
        if($lastFight < time()-6*3600)
            $fight = true;
        $delta = ($lastFight+6*3600)-time();

        // Calculate if he can be healed or not
        $lastHeal = $pokemon->getLastHeal();
        if($lastHeal < time()-24*3600)
            $heal = true;
        $dHeal = ($lastHeal+24*3600)-time();

    }
    // Save the new pokemon
    if(isset($_POST) && !empty($_POST)){
        if(isset($_POST['name']) && !empty($_POST['name']))
            if(isset($_POST['type']) && 'null' !== $_POST['type']){
                /** @var Pokemon $pokemon */
                $pokemon = new Pokemon();
                // Create the new pokemon
                try {
                    $pokemon
                        ->setTrainer($trainer)
                        ->setHP(100)
                        ->setName($_POST['name'])
                        ->setLastfight(1)
                        ->setLastHeal(1)
                    ;
                    if($_POST['type'] == 'fire')
                        $pokemon->setType(Pokemon::TYPE_FIRE);
                    elseif($_POST['type'] == 'water')
                        $pokemon->setType(Pokemon::TYPE_WATER);
                    elseif($_POST['type'] == 'plant')
                        $pokemon->setType(Pokemon::TYPE_PLANT);

                }
                catch(Exception $e){
                    $error = $e->getMessage();
                }
                try {
                    $em->persist($pokemon);
                    // Add it in database
                    $em->flush();
                    header('Location:dashboard.php');
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
            else
                $error = "Please select a type for your pokemon";
        else
            $error = 'Please choose a name for your pokemon';
    }



// Display the model
echo $twig ->render('dashboard.html.twig',[
    'pokemon' => $pokemon,
    'error' => $error,
    'fight' => $fight,
    'delta' => $delta,
    'dHeal' => $dHeal,
    'heal' => $heal,
    'fightaffiche' => TransformHour($delta),
    'healAffiche' => TransformHour($dHeal),
]);
