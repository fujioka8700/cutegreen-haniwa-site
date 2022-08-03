<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Plant extends Model
{
    use HasFactory;

    /** JSONに追加する属性 */
    protected $appends = [
      'url',
    ];

    /** JSONに含める属性 */
    protected $visible = [
      'owner', 'url', 'id'
    ];

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
      return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }

    public function getUrlAttribute()
    {
      return Storage::cloud()->url($this->attributes['filename']);
    }

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
