<?php

namespace App\Components;

class Analytics
{
    private $tid="UA-124655500-1";
    /**
     * setEvent
     *
     * @param  client_id $cid
     * @param  event_category $ec
     * @param  event_action $ea
     * @param  event_label $el
     * @param  event_value $ev
     * @return void
     */
    public function setEvent($cid,$ec,$ea="click",$el="button",$ev="Click Here")
    {
        // GA curl
        $req = curl_init('https://www.google-analytics.com/collect');

        curl_setopt_array($req, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POSTFIELDS =>
            'v=1&t=event&tid='.$this->tid.'&cid='.$cid.'&ec='.$ec.'&ea='.$ea.'&el='.$el.'&uip='.$this->ip().'&ds=app'
        ));
        // Send the request
       return $response = curl_exec($req);
    }
    public function ip() {
		$ip = false;
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = trim(array_shift($ip));
		}
		elseif(isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}
