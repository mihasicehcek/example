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

class SendedCallsService2
{

    public function __construct(CallRepositoryInterface $callRepository, CallSendedLogsRepositoryInterface $callSendedRepo)
    {
        $this->callsRepo = $callRepository;
        $this->callSendedRepo = $callSendedRepo;
    }

    /**
     * Тут я погружаю отпраленные звонки к звонкам. Избавился от захлоамляющего форича влженного, но теперь я ображаюсь к базе из сервиса.
     * Что являеться очень плохой и жосткой зависимостью.
     *
     * @param $projectId integer
     *
     * @param $from Carbon
     *
     * @param $to Carbon
     *
     * @return SendingCallResult[]
     *
     * */
    public function getSendingResult($projectId, Carbon $from, Carbon $to){
        $result = [];

        $calls = $this->callsRepo->getCallsBetweenDays($projectId, $from, $to);
        $calls->load("sendedCalls");

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

    private $callsRepo;
    private $callSendedRepo;

}