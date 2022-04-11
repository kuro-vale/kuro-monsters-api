<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Http\Requests\StoreMonsterRequest;
use App\Http\Requests\UpdateMonsterRequest;
use App\Http\Resources\MonsterResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MonsterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $monsters = Monster::latest()->when($request->has('username'), function (Builder $query) use ($request) // Search monsters by ?username=
        {
            return $query->whereHas('user', function (Builder $q) use ($request) // Where Monster::Has(User::class)
            {
                return $q->where('username', 'like', '%' . $request->get('username') . '%'); // Where monster->user->username like ?username=
            });
        })->paginate(5)->appends([
            'username' => $request->get('username')
        ]);
        if (!$monsters['data'])
        {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return MonsterResource::collection($monsters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMonsterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonsterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function show(Monster $monster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMonsterRequest  $request
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonsterRequest $request, Monster $monster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monster $monster)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
}
