<?php

use danolez\lib\DB\Controller\Controller;
use danolez\lib\DB\Model\Model;
use Demae\Auth\Models\Error\Error;
use Demae\Auth\Models\Shop\Administrator\Administrator;
use Demae\Auth\Models\Shop\Branch\Branch;
use Demae\Auth\Models\Shop\Log\Log;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Auth\Models\Shop\User\User;

class DashboardController extends Controller
{

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function management()
    {
        if (isset($_POST['add-branch'])) {
        } else if (isset($_POST['add-staff'])) {
        } else if (isset($_POST['create-product'])) {
        } else return null;
    }

    public function general()
    {
        # code...
    }

    public function createProduct()
    {
        $product = new Product();
        $product->setAvailability($_POST['product-availability']);
        $product->setPrice($_POST['product-price']);
        $product->setName($_POST['product-name']);
        $product->setDescription($_POST['product-description']);
        $product->setDisplayImage($_POST['product-img']);
        if (isset($_POST['product-category']))
            $product->setCategory($_POST['product-category']);
        $product->setProductOptions($_POST['options']);
        $product->setTimeCreated(time());
        $product->setAuthor(array($this->admin->getUsername(), $this->admin->getId()));
        if ($this->admin->getRole() == '1' && isset($_POST['product-branch'])) {
            $product->setBranchId($_POST['product-branch']);
        } else {
            $product->setBranchId($this->admin->getBranchId());
        }
        return $product->create();
    }

    public function createBranch()
    {
        if ($this->admin->getRole() == 1) {
            $branch = new Branch();
            $branch->setName($_POST['name']);
            $branch->setLocation($_POST['location']);
            $branch->setStaffNo($_POST['staff-no'] ?? 0);
            $branch->setStatus($_POST['status'] ?? 1);
            $log = new Log();
            $branch->setLog(json_encode($log->properties()));
            $branch->setAdmin($this->admin->getId());
            $branch->setTimeCreated(time());
            return $branch->add();
        } else {
            $return[Model::ERROR] = Error::Unauthorised;
            return json_encode($return);
        }
    }

    public function createAdmin()
    {
        $admin = new Administrator();
        $admin->setEmail($_POST['email']);
        $admin->setName($_POST['name']);
        $admin->setRole($_POST['role']);
        $log = new Log();
        $admin->setLog(json_encode($log->properties()));
        $admin->setAddedBy($this->admin->getId());
        $admin->setBranchId($_POST['branch']);
        return $admin->register();
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
