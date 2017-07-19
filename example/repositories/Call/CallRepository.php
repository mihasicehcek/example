<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 26.06.2017
 * Time: 16:43
 */

namespace App\Repositories\Call;


use App\Collections\CallsCollection;
use Carbon\Carbon;

class CallRepository implements CallRepositoryInterface
{

    /**
     *
     * @param $project_id integer
     *
     * @param $from Carbon
     *
     * @param $to Carbon
     *
     * @return CallsCollection
     * */
    public function getCallsBetweenDays($project_id, Carbon $from, Carbon $to)
    {
        return \Call::where("project_id", '=', $project_id)->whereBetween("calldate", [$from, $to])->get();
    }
}