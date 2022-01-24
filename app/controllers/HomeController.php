<?php
namespace App\Controllers;

use App\Exceptions\AccountIsBlockedException;
use App\Exceptions\NotEnoughMoneyException;
use App\QueryBuilder;
use Delight\Auth\Auth;
use Exception;
use League\Plates\Engine;

class HomeController
{
    private $templates;
    private $auth;
    private $qb;

    public function __construct(QueryBuilder $qb, Engine $templates, Auth $auth)
    {
        $this->qb = $qb;
        $this->templates = $templates;
        //$db = new \PDO('mysql:host=localhost;dbname=delight_database;charset=utf8', 'root', 'root');
        $this->auth = $auth;
    }

    public function index() {
        d($this->qb);die();

        $db = new QueryBuilder();
        $posts = $db->getAll('posts');
        echo $this->templates->render('homepage', ['posts' => $posts]);
    }

    public function about($vars) {


        try {
            $userId = $this->auth->register('a@a.a', '123', 'An', function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        //echo $this->templates->render('about', ['name' => 'Jonathan']);
    }
    public function email_verification () {
        try {
            $this->auth->confirmEmail('DNSAv382QSsJg7nY', 'Diqrtrtd3SPElwe2');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
    public function login() {
        try {
            $this->auth->login('a@a.a', '123');

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}