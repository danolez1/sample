<?php

namespace danolez\lib\Res;

use Demae\Auth\Models\Shop\Setting;
use Exception;
use PrintNode\Account;
use PrintNode\ApiKey;
use PrintNode\Credentials;
use PrintNode\Printer;
use PrintNode\PrintJob;
use PrintNode\Request;

require_once('app\lib\php\Res\PrintNode\src\PrintNode\EntityInterface.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Entity.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Account.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\ApiKey.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Client.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Computer.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\CredentialsInterface.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Credentials.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Download.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\PrintJob.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Printer.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Request.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Response.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Scale.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\State.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Tag.php');
require_once('app\lib\php\Res\PrintNode\src\PrintNode\Whoami.php');

class PrintNodeApi
{
    private $request;
    private $computers;
    private $printers;
    private $printJobs;
    private $defaultPrinter;
    private $content;
    private $src;
    private $title;
    private $api;

    const PRINTNODE_APIKEY = "8c6b_YpmVV3v_HQzu0lx5dEA8KSD4yj1agp9v6PHsuc";
    const CONTENT_TYPE = "pdf_base64";

    public function __construct($api = null)
    {
        if (!is_null($api)) {
            $this->setApi($api);
        }
    }

    public function print()
    {
        $printJob = new PrintJob();
        foreach ($this->printers as $printer) {
            if ($printer->getId() == $this->defaultPrinter)
                $printJob->printer = $printer;
        }
        if ($printJob->printer instanceof Printer) {
            $printJob->contentType = self::CONTENT_TYPE;
            $printJob->content = base64_encode(($this->content));
            $printJob->source = $this->src;
            $printJob->title = $this->title;
            $response = $this->request->post($printJob);
            $statusCode = $response->getStatusCode();
            $statusMessage = $response->getStatusMessage();
            $headers = $response->getHeaders();
            $content = $response->getContent();
            return json_encode(array('statusCode' => $statusCode, 'statusMessage' => $statusMessage, 'header' => $headers, 'content' => $content,));
        } else {
            return false;
        }
    }

    public function createStore($firstName, $lastName, $email, $password)
    {
        $account = new Account();
        $account->Account = array(
            "firstname" => $firstName,
            "lastname" => $lastName,
            "password" => $password,
            "email" => $email
        );
        $aNewAccount = $this->request->post($account);
        // $id = $aNewAccount->GetDecodedContent()["Account"]["id"];
        return json_encode($aNewAccount->GetDecodedContent());
    }

    public function getStore($id)
    {
        /* - PrintNode\Request->setChildAccountById($id)
 * - PrintNode\Request->setChildAccountByEmail($email)
 * - PrintNode\Request->setChildAccountByCreatorRef($creatorRef)
 *
 * We will set the Child Account by ID
 **/
        $this->request->setChildAccountById($id);
        $whoami = $this->request->getWhoami();
        $this->computers = $this->request->getComputers();
        $this->printers = $this->request->getPrinters();
        return $whoami;
    }

    public function updateStore()
    {
        $account = new Account();
        // Let's change the Child Account name.
        $account->Account = array(
            "firstname" => "ANewFirstName",
            "lastname" => "ANewLastName"
        );
        $this->request->patch($account);
        $whoamiNow = $this->request->getWhoami();
    }


    public function deleteStore()
    {
        $this->request->deleteAccount();
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of src
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set the value of src
     *
     * @return  self
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of defaultPrinter
     */
    public function getDefaultPrinter()
    {
        return $this->defaultPrinter;
    }

    /**
     * Set the value of defaultPrinter
     *
     * @return  self
     */
    public function setDefaultPrinter($defaultPrinter)
    {
        $this->defaultPrinter = $defaultPrinter;

        return $this;
    }

    /**
     * Get the value of printers
     */
    public function getPrinters()
    {
        return $this->printers;
    }

    /**
     * Get the value of computers
     */
    public function getComputers()
    {
        return $this->computers;
    }

    /**
     * Get the value of printJobs
     */
    public function getPrintJobs()
    {
        return $this->printJobs;
    }

    /**
     * Get the value of api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set the value of api
     *
     * @return  self
     */
    public function setApi($api)
    {
        $credentials = new Credentials();
        $this->api = $api;
        $credentials->setApiKey($api);
        $this->request = new Request($credentials);
        try {
            set_time_limit(0);
            $this->computers = $this->request->getComputers();
            $this->printers = $this->request->getPrinters();
            $this->defaultPrinter = Setting::getInstance()->getDefaultPrinter();
            $this->printJobs = $this->request->getPrintJobs();
        } catch (Exception $e) {
            // var_dump($e->getMessage());
        }

        return $this;
    }
}
