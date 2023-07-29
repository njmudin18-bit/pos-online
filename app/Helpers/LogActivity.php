<?php

namespace App\Helpers;

use Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
  public static function addToLog($subject, $data = null, $old_data = null)
  {
    $log              = [];
    $log['subject']   = $subject;
    $log['url']       = Request::fullUrl();
    $log['method']    = Request::method();
    $log['data']      = json_encode($data);
    $log['old_data']  = $old_data;
    $log['agent']     = Request::header('user-agent');
    $log['user_id']   = auth()->check() ? auth()->user()->id : 1;

    LogActivityModel::create($log);
  }

  public static function logActivityLists()
  {
    return LogActivityModel::latest()->get();
  }
}
