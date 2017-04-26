<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Relenta\Ply\Models\Card;

class Learn extends Controller
{
    public function index(Request $request, $id)
    {
        return Card::where(['unit_id' => $id])->with('sides')->get();
    }
}
