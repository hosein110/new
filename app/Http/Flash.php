<?php
/**
 * Created by PhpStorm.
 * User: heydari
 * Date: 3/12/2018
 * Time: 7:00 PM
 */

namespace App\Http;


Class Flash
{
    private $title = 'title';
    private $message = 'message';
    private $level = 'info';
    private $timer = '2000';
    private $button = 'تایید';
    private $key = 'flash_message';
    private $overlay = false;


    public function create()
    {
        session()->flash($this->keys(), [
            'title' => $this->title,
            'message' => $this->message,
            'level' => $this->level,
            'button' => $this->button,
            'timer' => $this->timer,

        ]);
    }

    public function timer($timer = 2000)
    {
        $this->timer = $timer;
        return $this;
    }

    public function info($title = 'title', $message = 'message', $overlay = false, $buttonName = 'تایید')
    {
        $this->title = $title;
        $this->message = $message;
        $this->level = "info";
        $this->overlay = $overlay;

        $this->button = $buttonName;
        return $this->create();
    }

    public function success($title = 'title', $message = 'message', $overlay = false, $buttonName = 'تایید')
    {
        $this->title = $title;
        $this->message = $message;
        $this->level = "success";
        $this->overlay = $overlay;

        $this->button = $buttonName;
        return $this->create();
    }

    public function error($title = 'title', $message = 'message', $overlay = false, $buttonName = 'تایید')
    {
        $this->title = $title;
        $this->message = $message;
        $this->level = "error";
        $this->overlay = $overlay;
 
        $this->button = $buttonName;
        return $this->create();
    }


    private function keys()
    {
        if ($this->overlay)
            return $this->key = 'flash_message_overlay';
        else
            return $this->key = 'flash_message';

    }
}