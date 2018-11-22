<?php

namespace App\Model;

class Task
{
    protected $id;
    protected $username;
    protected $email;
    protected $text;
    protected $image;

    public function __construct($username = null, $email = null, $text = null, $image = null)
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


    //todo: probably, have to move it out
    public static function create(array $data)
    {
        $task = new self();

        foreach ($data as $key => $value) {
            if (property_exists($task, $key)) {
                $task->{$key} = $value;
            }
        }

        return $task;
    }

}