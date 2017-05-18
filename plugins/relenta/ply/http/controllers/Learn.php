<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;

class Learn extends Controller
{

    public function index(Request $request)
    {
        try {
            $commonValidator = Validator::make($request->all(), [
                'learn-id'   => 'required',
                'learn-type' => 'required|in:course,unit',
                'mode'       => 'required',
            ]);

            $this->validateLearnRequest($commonValidator);

            $courseValidator = Validator::make($request->only(['learn-id']), [
                'learn-id' => 'required|exists:relenta_ply_course,id',
            ]);

            $unitValidator = Validator::make($request->only(['learn-id']), [
                'learn-id' => 'required|exists:relenta_ply_unit,id',
            ]);

            if ($request->get('learn-type') == 'unit') {
                $this->validateLearnRequest($unitValidator);

                $units = Unit::find($request->get('learn-id'))->children()->get()->pluck('id')->all();
                $units[] = $request->get('learn-id');
                $cards = Card::whereIn('unit_id', $units);
                
            } elseif ($request->get('learn-type') == 'course') {
                $this->validateLearnRequest($courseValidator);

                $cards = Card::where('course_id', $request->get('learn-id'));
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => '404',
                'message' => 'Course not found or you are not allowed access this course'
            ], 404);
        }

        return $cards->with('sides')->get();
    }

    private function validateLearnRequest($validator) {
        if($validator->fails()) {
            throw new Exception("Error Processing Request", 1);
        }
    }

}
