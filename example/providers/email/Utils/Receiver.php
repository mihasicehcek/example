<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 15:28
 */

namespace Providers\Email\Utils;


class Receiver
{

    public function __construct($email, $name, $subject)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
    }

    private $email;
    private $name;
    private $subject;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

}