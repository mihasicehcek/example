<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 16:11
 */

namespace App\Integrations\Bitrix24;


use App\Models\Integrations\Bitrix24\Bitrix24CallSendLog;

interface CallSendedLogsRepositoryInterface
{

    /**
     * @param $callIds integer[]
     *
     * @return Bitrix24CallSendLog[]
     * */
    public function getSendedLogsByCallsIds(array $callIds);


    public function loadSededCallsToCalls(CallsCollection $calls);


    public function loadSededCallsToCall(Call $call);


}