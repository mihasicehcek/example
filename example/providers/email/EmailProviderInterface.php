<?php

namespace Providers\Email;

use Providers\Email\Utils\Attachs;
use Providers\Email\Utils\Receiver;

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