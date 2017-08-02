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
use Psr\Log\LoggerInterface;

class SendedCallsService6
{

    public function __construct(CallSendedLogsRepositoryInterface $callSendedRepo, LoggerInterface $logger)
    {
        $this->callSendedRepo = $callSendedRepo;
        $this->logger = $logger;
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

    /**
     * @param $emailProvider \Providers\Email\EmailProviderInterface
     *
     * @param $calls CallsCollection
     *
     * @param $receivers \Providers\Email\Utils\Receiver[]
     *
     * @return void
     *
     * */
    public function sendReport(\Providers\Email\EmailProviderInterface $emailProvider, array $calls, array $receivers, LoggerInterface $logger)
    {
        $sendedCalls = $this->getSendingResult($calls);
        $csv = $this->generateSendingResultAsCsv($sendedCalls);
        $attachs = [
            new \Providers\Email\Utils\Attachs($csv, "calltracking_bitrix_sending_repost.csv", [
                'mime' => 'text/csv'
            ])
        ];

        $emailProvider->send("emails.reports.integration.bitrix24.not_sended_calls_report", ["sendedCalls" => $sendedCalls], $receivers, $attachs);
        $logger->info("Емайл отправлен");
        $logger->info(print_r($receivers, true));
    }

    /**
     * @param $sendedCalls SendingCallResult[]
     *
     * @return string
     * */
    private function generateSendingResultAsCsv($sendedCalls){
        $csv = ( chr(0xEF) . chr(0xBB) . chr(0xBF) );
        $csv .= implode(",", ["Время звонка", "Номер звонящего", "Отправлен ли в битрикс24", "Время отправки в битрикс24"]);
        $csv .= "\n\r";

        foreach($sendedCalls as $sendedCall){
            $csv .= implode(",", [
                $sendedCall->getCalldate()->format("Y-m-d H:i:s"),
                $sendedCall->getSrc(),
                $sendedCall->getResult() ? "Да" : "Нет",
                $sendedCall->getResult() ? $sendedCall->getSendedAt()->format("Y-m-d H:i:s") : ""
            ]);
            $csv .= "\n\r";
        }

        return $csv;
    }

    private $callSendedRepo;

    private $logger;

}