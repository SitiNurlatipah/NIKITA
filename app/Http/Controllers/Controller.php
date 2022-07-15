<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function random_string($repeat=2,$length=30,$symbol=true)
    {
      $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      if ($symbol) {
        $pool .= '!@#$%^&*(_=)';
      }
      return substr(str_shuffle(str_repeat($pool, $repeat)), 0, $length);
    }

    private function rekursif_validate($r,$data,$vkey){
      $data = [];
      if (array_keys($r)[0] == range(0,count($r)-1)) {
        for ($i=0; $i < count($r); $i++) {
          if (is_array($r[$i])) {
            $data[$i] = [];
            $data[$i] = $this->rekursif_validate($r[$i],$data[$i],$key);
          }else{
            $data[$i] = str_replace("--","\-\-",addslashes(trim(htmlentities(strip_tags(str_replace("  "," ",$r[$i]))))));
          }
        }
      }else{
        $idx = 0;
        foreach ($r as $key => $req) {
          if (is_numeric($key)) {
            if (is_array($req)) {
              $data[$idx] = [];
              $data[$idx] = $this->rekursif_validate($req,$data[$idx],$key);
            }else{
              $data[$idx] = str_replace("--","\-\-",addslashes(trim(htmlentities(strip_tags(str_replace("  "," ",$req))))));
            }
            $idx++;
          }else{
            if (is_array($req)) {
              $data[$key] = [];
              $data[$key] = $this->rekursif_validate($req,$data[$key],$key);
            }else{
              $data[$key] = str_replace("--","\-\-",addslashes(trim(htmlentities(strip_tags(str_replace("  "," ",$req))))));
            }
          }
        }
      }
      return $data;
    }

    public function validate_input_v2($request,$except=[])
    {
      $this->tempData = [];
      array_push($except,"_token",'button');
      $i = 0;
      foreach ($request->except($except) as $key => $r) {
        if (is_array($r)) {
          $this->tempData[$key] = [];
          $this->tempData[$key] = $this->rekursif_validate($r,$this->tempData[$key],$key);
        }else{
          $this->tempData[$key] = str_replace("--","\-\-",addslashes(trim(htmlentities(strip_tags(str_replace("  "," ",$r))))));
          if ($this->tempData[$key] == '') {
            $this->tempData[$key] = null;
          }
        }
      }
      return $this->tempData;
    }
}
