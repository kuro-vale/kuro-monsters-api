<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Http\Requests\StoreMonsterRequest;
use App\Http\Requests\UpdateMonsterRequest;
use App\Http\Resources\MonsterResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        })->where('dead', '!=', 1)->paginate(5)->appends([
            'username' => $request->get('username')
        ]);
        if (count($monsters) == 0)
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
        $monster = Monster::create([
            'user_id' => Auth::id(),
        ] + $request->all());

        return new MonsterResource($monster);
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
