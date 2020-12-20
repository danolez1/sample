<?php

use danolez\lib\DB\Controller\Controller;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use Demae\Auth\Models\Shop\Log\Log;
use Demae\Auth\Models\Shop\User\User;

class UserController extends Controller
{

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function authentication()
    {
        if (isset($data['login'])) {
            return $this->auth();
        } else if (isset($data['sign-up'])) {
            return $this->register();
        } else if (isset($data['register'])) {
            return $this->createAdmin();
        } else if (isset($data['auth'])) {
            return $this->authenticate();
        } else return null;
    }

    protected function auth()
    {
        $user = new User();
        $user->setEmail($this->data['lemail']);
        $user->setPassword($this->data['lpassword']);
        return ($user->authenticate());
    }

    protected function register()
    {
        $user = new User();
        $user->setName($this->data['name']);
        $user->setEmail($this->data['remail']);
        $user->setPhoneNumber($this->data['phone']);
        $user->setPassword($this->data['rpassword']);
        $log = new Log();
        $user->setLog(json_encode($log->properties()));
        $user->setTimeCreated(time());
        return $user->register();
    }

    protected function createAdmin()
    {
        $admin = new Administrator();
        $admin->setEmail($this->data['email']);
        $admin->setName($this->data['name']);
        $admin->setRole($this->data['role']);
        $log = new Log();
        $admin->setLog(json_encode($log->properties()));
        $admin->setAddedBy($this->admin->getId());
        $admin->setBranchId($this->data['branch']);
        return $admin->register();
    }

    protected function authenticate()
    {
        $admin = new Administrator();
        $admin->setUsername($this->data['username']);
        $admin->setPassword($this->data['password']);
        return ($admin->authenticate());
    }

    protected function decode()
    {
    }
    public function setApi($api)
    {
    }
    protected function setProperties()
    {
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
