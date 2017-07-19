<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 14.07.2017
 * Time: 17:56
 */

namespace App\Classes\Providers\Email\Utils;


class Attachs
{

    private $data;

    private $view;

    private $info;

    /**
     * Attachs constructor.
     * @param $data
     * @param $filename
     * @param $info
     */
    public function __construct($data, $filename, $info)
    {
        $this->data = $data;
        $this->view = $filename;
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }



}