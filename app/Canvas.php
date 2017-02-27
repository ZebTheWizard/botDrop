<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Canvas extends Model
{
    protected $table = "canvases";
    protected $fillable = [
      'url',
      'user_id',
    ];


    public static function create(array $array){
      if($array){
        $c = new Canvas;
        $c->url = rand_64(11);
        $c->user_id = $array['user_id'];

        try {
          $c->save();
        }catch (Exception $e){
          return abort(503);
        }
      }
    }


    public function drop(){
      $this->delete();
    }
}
