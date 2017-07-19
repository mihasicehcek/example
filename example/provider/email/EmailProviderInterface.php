<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 15:25
 */

namespace App\Classes\Providers\Email;


use App\Classes\Providers\Email\Utils\Attachs;
use App\Classes\Providers\Email\Utils\Receiver;

interface EmailProviderInterface
{

    /**
     * @param $view string
     *
     * @param $data []
     *
     * @param $to Receiver[]
     *
     * @param $attachs Attachs[]
     * */
    public function send($view, array $data, array $to, array $attachs = []);

}