<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class MyTableController extends Controller
{
   
    {
        $records = DB::table('my_table')->get();
        return view('my_table.index', compact('records'));
    }
}
?>