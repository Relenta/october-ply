<?php

namespace Relenta\Ply\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;
use RainLab\User\Facades\Auth;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\Unit;
use Relenta\Ply\Models\User;

class Learn extends Controller {

    public function index(
        Request $request
    ) {
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

            $user = Auth::getUser();

            if ($request->get('learn-type') == 'unit') {
                $this->validateLearnRequest($unitValidator);
                $unit_id = $request->get('learn-id');

                $unit = Unit::find($unit_id);
                $units = $unit->children()->get()->pluck('id')->all();
                $units[] = $unit_id;

                // Check Course subscription
                $this->checkSubscription($user, $unit->course->id);

                $cards = Card::whereIn('unit_id', $units);
            } elseif ($request->get('learn-type') == 'course') {
                $this->validateLearnRequest($courseValidator);
                $course_id = $request->get('learn-id');

                $this->checkSubscription($user, $course_id);

                $cards = Card::where('course_id', $request->get('learn-id'));
            }
        } catch (Exception $e) {
            return response()->json([
                'code'    => '404',
                'message' => 'Course not found or you are not allowed access this course',
            ], 404);
        }

        return $cards->with('sides')->get();
    }

    private function validateLearnRequest(
        $validator
    ) {
        if ($validator->fails()) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    private function checkSubscription($user, $course_id)
    {
        if (! $user->course_subscriptions()->find($course_id)) {
            $user->course_subscriptions()->attach($course_id, [
                "subscribed_at"           => time(),
                "subscription_expires_at" => "",
            ]);
        }
    }
}
