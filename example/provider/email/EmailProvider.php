<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 15:24
 */

namespace App\Classes\Providers\Email;


use App\Classes\Providers\Email\Utils\Attachs;
use App\Classes\Providers\Email\Utils\Receiver;

class EmailProvider implements EmailProviderInterface
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
    public function send($view, array $data, array $to, array $attachs = [])
    {
        \Mail::send($view, $data, function($message) use ($to, $attachs)
        {
            foreach ($to as $item){
                $message->to($item->getEmail(), $item->getName())->subject($item->getSubject());
            }

            foreach($attachs as $attachData){
                $message->attachData($attachData->getData(), $attachData->getView(), $attachData->getInfo()
            );
        }
        });
    }

}