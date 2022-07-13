<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Http\Requests\StorePicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function __construct()
    {
      /**
       * 認証が必要
       */
      $this->middleware('auth');
    }

    /**
     * 写真投稿
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePicture $request)
    {
      // 投稿写真の拡張子を取得する
      $extension = $request->picture->extension();

      $picture = new Picture();

      // インスタンス生成時に割り振られたランダムなID値と
      // 本来の拡張子を組み合わせてファイル名とする
      $picture->filename = $picture->id . '.' . $extension;

      // S3 にファイルを保存する
      // テスト時は storage/framework/testing/disks/s3/ にファイルを保存する
      Storage::cloud()->putFileAs('', $request->picture, $picture->filename);

      // データベースエラー時にファイル削除を行うため
      // トランザクションを利用する
      DB::beginTransaction();

      try {
        Auth::user()->pictures()->save($picture);
        DB::commit();
      } catch (\Exception $extension) {
        DB::rollBack();

        // データベースとの不整合を避けるためアップロードしたファイルを削除
        Storage::cloud()->delete($picture->filename);
        throw $extension;
      }

      // リソースの新規作成なので
      // レスポンスは201(CREATED)を返却する
      return response($picture, 201);
    }
}