<?php

namespace App\Model;

class Task
{
    protected $id;
    protected $username;
    protected $email;
    protected $text;
    protected $image;
    protected $done;

    /**
     * @var array
     */
    protected $updated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
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

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDone()
    {
        return $this->done;
    }

    public function setDone($done)
    {
        $this->done = $done;
    }

    public function isDone()
    {
        return $this->done ? 'Done' : 'To Do';
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

    /**
     * @param array $data
     */
    public function save(array $data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($this->nameCamelCase($name));
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } elseif (property_exists($this, $name)) {
            $this->{$name} = $value;
        } else {
            throw new \Exception("Property '$name' does not exist");
        }
    }

    public function __get($name)
    {
        $name = $this->nameCamelCase($name);

        if (property_exists($this, $name)) {
            return $this->{$name};
        }
    }

    public function nameCamelCase($name)
    {
        $parts = explode('_', $name);
        $i = 0;
        $camelCased = array_reduce($parts, function ($carry, $item) use (&$i) {
            $item = $i > 0 ? ucfirst($item) : $item;
            $i++;
            return $carry . $item;
        }, '');
        return $camelCased;
    }

    public function populateWith($data)
    {
        foreach ($data as $key => $value) {
            $this->updated[] = $key;
            $this->__set($key, $value);
        }
    }

    /**
     * @return array
     */
    public function getUpdatedKeys()
    {
        return $this->updated;
    }
}