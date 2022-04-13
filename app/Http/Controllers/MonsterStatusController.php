<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MonsterStatusController extends Controller
{
    public function show(Monster $monster)
    {
        return response()->json([
            'name' => $monster->name,
            'life' => $monster->life,
            'hunger' => $monster->hunger,
            'energy' => $monster->energy,
            'sleeping' => boolval($monster->sleeping),
            'dead' => boolval($monster->dead),
        ]);
    }

    public function update(Request $request, Monster $monster)
    {
        $this->authorize('update', $monster);

        if ($monster->dead)
        {
            return response()->json([
                'message' => "$monster->name is dead."
            ], Response::HTTP_FORBIDDEN);
        }

        if ($monster->created_at != $monster->fed_at)
        {
            $fed_at =  new DateTime($monster->fed_at);
            $delay_time = $fed_at->add(new DateInterval('PT' . 60 . 'M'));
            if ($delay_time > Carbon::now()) // This request can only be executed every 60 minutes
            {
                $remaining_time = $delay_time->diff(Carbon::now())->format('%i:%s'); // Show remaining time
                return response()->json([
                    'message' => "You need to wait $remaining_time minutes to perform this action."
                ], Response::HTTP_FORBIDDEN);
            }
        }

        if ($request->has('feed'))
        {
            if ($monster->sleeping) // Prevent to feed monster if is sleeping
            {
                return response()->json([
                    'message' => "$monster->name is sleeping."
                ], Response::HTTP_FORBIDDEN);
            }
            $monster->hunger -= 25; // Feed the monster
            if ($monster->hunger < 0) // Prevent hunger go under 0
            {
                $monster->hunger = 0;

                $monster->life += 25; // Increase life of dying monsters
                if ($monster->life > 100)
                {
                    $monster->life = 100; // Prevent life go over 100
                }
            }
            $monster->fed_at = Carbon::now();
            $monster->save();
        }
        elseif ($request->has('sleep'))
        {
            $monster->sleeping = true;
            $monster->save();
        }

        return response()->json([
            'name' => $monster->name,
            'life' => $monster->life,
            'hunger' => $monster->hunger,
            'energy' => $monster->energy,
            'sleeping' => boolval($monster->sleeping),
        ]);
    }
}
