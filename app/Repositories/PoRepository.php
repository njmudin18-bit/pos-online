<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\PoModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class PoRepository.
 */
class PoRepository extends BaseRepository
{
  /**
   * @return string
   *  Return the model
   */
  public function get_all_po($table)
  {
    $data = DB::table($table)
      ->orderByDesc('TGL')
      ->get();

    if ($data == null) {
      return $result = array(
        'code'    => 404,
        'status'  => 'error',
        'message' => 'Data PO tidak ditemukan',
        'data'    => $data
      );
    } else {
      return $result = array(
        'code'    => 200,
        'status'  => 'success',
        'message' => 'Data PO ditemukan',
        'data'    => $data
      );
    }
  }
}
