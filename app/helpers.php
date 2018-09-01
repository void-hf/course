<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/07/27
 * Time: 下午 03:36
 */
function show($status,$msg,$data=''){
    $res = array(
        'status'=>$status,
        'msg'=>$msg,
        'data'=>$data
    );
    return response()->json($res);
}

function eShow($data){
    $status = $data[0];
    $msg = $data[1];
    $res = array(
        'status'=>$status,
        'msg'=>$msg,
        'data'=>""
    );
    return response()->json($res);
}

function weekday($time)
{
    if(is_numeric($time))

    {
        $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        return $weekday[date('w', $time)];

    }
    return false;

}

