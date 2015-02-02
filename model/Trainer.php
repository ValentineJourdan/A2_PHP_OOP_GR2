<?php


namespace Xusifob\PokemonBattle;

/**
 * Class Trainer
 *
 * @package Xusifob\PokemonBattle
 *
 * @Entity
 * @Table(name="trainer")
 */
class Trainer implements Model\TrainerInterface
{

    /**
     * @var int
     *
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="username", type="string", length=30)
     */
    private $userName;


    /**
     * @var string
     *
     * @Column(name="password", type="string", length=30)
     */
    private $password;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * {@inheritdoc}
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function setUserName($userName)
    {
        if(is_string($userName) && !empty($userName))
            $this->userName = $userName;
        else
            throw new \Exception('username must be a string & not empty');

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function setPassword($password)
    {
        if(is_string($password) && !empty($password))
            $this->password = $password;
        else
            throw new \Exception('Password must be a string & not empty');

        return $this;
    }


}