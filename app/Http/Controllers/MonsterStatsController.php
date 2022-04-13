<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MonsterStatsController extends Controller
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

        if (strtotime($monster->updated_at->add(new DateInterval('PT' . 20 . 'M'))) > time()) // This request can only be performed every 20 minutes
        {
            $remaining_time = date('i:s', strtotime($monster->updated_at->add(new DateInterval('PT' . 20 . 'M'))) - time()); // Show remaining time
            return response()->json([
                'message' => "You need to wait $remaining_time minutes to perform this action"
            ], Response::HTTP_FORBIDDEN);
        }

        if ($monster->dead or $monster->sleeping)
        {
            return response()->json([
                'message' => "$monster->name is sleeping or dead which is the same as being asleep forever >:)"
            ], Response::HTTP_FORBIDDEN);
        }

        if ($request->has('feed'))
        {
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
            $monster->save();
        }
        elseif ($request->has('sleep'))
        {
            $monster->sleeping = true;
            $monster->save();
        }
        elseif ($request->has('wake_up'))
        {
            $monster->sleeping = false;
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
