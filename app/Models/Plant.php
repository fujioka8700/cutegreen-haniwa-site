<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Plant extends Model
{
    use HasFactory;

    /** 連番ではないので、incrementingをfalseにする */
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
      parent::__construct($attributes);

      if(! Arr::get($this->attributes, 'id')) {
        $this->setId();
      }
    }

    /** IDの桁数 */
    const ID_LENGTH = 32;

    /**
     * ランダムなID値をid属性に代入する
     * @return void
     */
    private function setId()
    {
      $this->attributes['id'] = Str::random(self::ID_LENGTH);
    }
}
