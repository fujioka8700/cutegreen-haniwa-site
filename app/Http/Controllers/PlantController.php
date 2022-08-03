<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlant;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
  public function __construct()
  {
    /**
     * 認証が必要
     */
    $this->middleware('auth')->except(['index']);
  }

  /**
   * 植物追加
   * @param StorePlant $request
   * @return \Illuminate\Http\Response
   */
  public function create(StorePlant $request)
  {
    $extension = $request->plant->extension();

    $plant = new Plant();

    $plant->filename = $plant->id . '.' . $extension;

    Storage::cloud()->putFileAs('', $request->plant, $plant->filename);

    DB::beginTransaction();

    try {
      Auth::user()->plants()->save($plant);
      DB::commit();
    } catch (\Exception $extension) {
      DB::rollBack();
      Storage::cloud()->delete($plant->filename);
      throw $extension;
    }

    return response($plant, 201);
  }

  /**
   * 植物一覧
   */
  public function index()
  {
    $plants = Plant::with(['owner'])->orderby(Plant::CREATED_AT, 'desc')->paginate();

    return $plants;
  }
}
