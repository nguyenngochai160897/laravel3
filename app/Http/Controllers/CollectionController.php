<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(){
        $collection = collect(['Chair', 'Desk']);

        $zipped = $collection->zip([100, 200]);

        $arr1 = ['a','b'];
        $arr2 = [1, 2];
        $array = array();
        for($i = 0; $i< count($arr1); $i++){
            array_push($array, [$arr1[$i] => $arr2[$i]]);
        }
        return response()->json($array, 200);
    }
}
