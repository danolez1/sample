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
    private $admin;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function management()
    {
        if (isset($this->data['add-branch'])) {
            return  $this->createBranch();
        } else if (isset($this->data['add-staff'])) {
            return $this->createAdmin();
        } else if (isset($this->data['create-product'])) {
            return $this->createProduct();
        } else return null;
    }

    protected function createProduct()
    {
        $product = new Product();
        $product->setAvailability($this->data['product-availability']);
        $product->setPrice($this->data['product-price']);
        $product->setName($this->data['product-name']);
        $product->setDescription($this->data['product-description']);
        $product->setDisplayImage($this->data['product-img']);
        if (isset($this->data['product-category']))
            $product->setCategory($this->data['product-category']);
        $product->setProductOptions($this->data['options']);
        $product->setTimeCreated(time());
        $product->setAuthor(array($this->admin->getUsername(), $this->admin->getId()));
        if ($this->admin->getRole() == '1' && isset($this->data['product-branch'])) {
            $product->setBranchId($this->data['product-branch']);
        } else {
            $product->setBranchId($this->admin->getBranchId());
        }
        return $product->create();
    }

    protected function createBranch()
    {
        if ($this->admin->getRole() == 1) {
            $branch = new Branch();
            $branch->setName($this->data['name']);
            $branch->setLocation($this->data['location']);
            $branch->setStaffNo($this->data['staff-no'] ?? 0);
            $branch->setStatus($this->data['status'] ?? 1);
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

    /**
     * Get the value of admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }
}
