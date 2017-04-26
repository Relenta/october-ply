<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Relenta\Ply\Models\Card;

class Learn extends Controller
{
    public function index(Request $request, $course_id, $unit_id = null)
    {
        if ($unit_id != null)
        {
            $cards = Card::where('unit_id', $unit_id);
        } elseif ($course_id != null)
        {
            $cards = Card::where('course_id', $course_id);
        }
        else
        {
            return [];
        }
        return $cards->with('sides')->get();
    }
}
