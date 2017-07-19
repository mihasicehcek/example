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

class SendedCallsService
{

    public function __construct(CallRepositoryInterface $callRepository, CallSendedLogsRepositoryInterface $callSendedRepo)
    {
        $this->callsRepo = $callRepository;
        $this->callSendedRepo = $callSendedRepo;
    }

    /**
     *
     * Тут я отедльно получил звонки и отдельно получил отправленные звонки и уже по ним цыклом бегаю, и получаю в итоге некий массив результатов
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
        /**@var \Call[] $calls*/
        $callIds = [];
        foreach($calls as $call){
            $callIds[] = $call->id;
        }
        $sendedCalls = $this->callSendedRepo->getSendedLogsByCallsIds($callIds);

        foreach($calls as $call){
            $sendingResult = new SendingCallResult();
            $sendingResult->setCalldate(new Carbon($call->calldate));
            $sendingResult->setSrc($call->src);
            foreach($sendedCalls as $sendedCall){
                if($sendedCall->call_id == $call->id){
                    $sendingResult->setResult(true);
                    $sendingResult->setSendedAt($sendedCall->created_at);
                }
            }

            $result[] = $sendingResult;
        }

        return $result;
    }

    private $callsRepo;
    private $callSendedRepo;

}