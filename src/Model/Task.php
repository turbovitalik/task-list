<?php

namespace App\Model;

class Task
{
    protected $id;
    protected $username;
    protected $email;
    protected $text;
    protected $image;

    public function __construct($username, $email, $text, $image)
    {
        $this->username = $username;
        $this->email = $email;
        $this->text = $text;
        $this->image = $image;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

}