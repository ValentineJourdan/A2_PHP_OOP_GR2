<?php

function TransformHour($totalsecondes)
{
    $secondes = $totalsecondes % 60;
    $minutes = ($totalsecondes / 60) % 60;
    $heures = floor($totalsecondes / (60 * 60));
    return[
        'heure' => $heures,
        'minutes' =>$minutes,
        'secondes' =>$secondes,
    ];
}


/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = require __DIR__.'/bootstrap.php';

Twig_Autoloader::register();

/** @var Twig_Loader_Filesystem $loader */
$loader = new Twig_Loader_Filesystem([
    __DIR__ .'/view/',
]);

/** @var Twig_Environment $twig */
$twig = new Twig_Environment($loader,[
    // 'cache' => null
]);

return $entityManager;
