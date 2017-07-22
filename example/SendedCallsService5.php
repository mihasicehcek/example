<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 15:19
 */

namespace App\Services\Integration\Bitrix24;

use App\Classes\Integration\Bitrix24\Services\DTO\SendingCallResult;
use App\Classes\Providers\Email\EmailProviderInterface;
use App\Classes\Providers\Email\Utils\Attachs;
use App\Classes\Providers\Email\Utils\Receiver;
use App\Integrations\Bitrix24\CallSendedLogsRepositoryInterface;
use App\Repositories\Call\CallRepositoryInterface;
use Carbon\Carbon;

class SendedCallsService5
{

    public function __construct(CallSendedLogsRepositoryInterface $callSendedRepo)
    {
        $this->callSendedRepo = $callSendedRepo;
    }

    /**
     * Тут в отличии от примера 3 подругзил звонки тоже в сервисе, то просто для все коллекции звонков
     *
     * @param $calls CallsCollection
     *
     * @return SendingCallResult[]
     *
     * */
    public function getSendingResult(CallsCollection $calls){
        $result = [];

        $this->callSendedRepo->loadSededCallsToCalls($calls);
        /**@var \Call[] $calls*/

        foreach($calls as $call){
            $sendingResult = new SendingCallResult();
            $sendingResult->setCalldate(new Carbon($call->calldate));
            $sendingResult->setSrc($call->src);
            if($call->sendedCall){
                $sendingResult->setSendedAt($call->sendedCall->created_at);
                $sendingResult->setResult(true);
            }

            $result[] = $sendingResult;
        }

        return $result;
    }

    private $callSendedRepo;

}