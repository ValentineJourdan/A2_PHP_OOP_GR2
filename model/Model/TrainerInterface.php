<?php

namespace Xusifob\PokemonBattle\Model;

interface TrainerInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     *
     * @return TrainerInterface
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     *
     * @return TrainerInterface
     */
    public function setPassword($password);
}