<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 16:54
 */

namespace App\Classes\Integration\Bitrix24\Services\DTO;


use Carbon\Carbon;

class SendingCallResult
{

    private $calldate;

    private $src;

    private $result = false;

    private $sended_at;

    /**
     * @return Carbon
     */
    public function getCalldate()
    {
        return $this->calldate;
    }

    /**
     * @param Carbon $calldate
     * @return SendingCallResult
     */
    public function setCalldate(Carbon $calldate)
    {
        $this->calldate = $calldate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     * @return SendingCallResult
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return SendingCallResult
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getSendedAt()
    {
        return $this->sended_at;
    }

    /**
     * @param Carbon $sended_at
     * @return SendingCallResult
     */
    public function setSendedAt(Carbon $sended_at)
    {
        $this->sended_at = $sended_at;
        return $this;
    }



}