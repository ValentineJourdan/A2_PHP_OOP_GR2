<?php
/** @var \Doctrine\ORM\EntityManager $em */
$em = require __DIR__ . '/_header.php';

if(!isset($_SESSION['connect']) || true !== $_SESSION['connect'])
    header('Location:connexion.php?action=connect');

return $em;