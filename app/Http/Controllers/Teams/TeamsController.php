<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Resources\TeamsResource;
use App\Http\Traits\HttpResponses;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TeamsResource::collection(Team::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreTeamRequest $request)
    {
        if ($request->user()->team) {
            return response()->json([
                'message' => 'The user with user ID: ' . $request->user()->id . ' already has a team.'
            ], 403);
        }

        $team = Team::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'body' => $request->body
        ]);

        return response()->json([
            'message' => 'Created.',
            'Team' => new TeamsResource($team)
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(int $id)
    {
        $team = Team::find($id);
        if ($team){
            return new TeamsResource($team);
        }
        return response()->json([
            'message' => 'Team not found.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     */
    public function update(StoreTeamRequest $request, int $id)
    {
        $team = Team::find($id);
        if ($team) {
            if ($this->isAuthorized($team)) {
                $team->update($request->validated());
                return response()->json([
                    'message' => 'Updated.'
                ]);
            }
            return response()->json([
                'message' => 'Not Authorized.'
            ]);
        }

        return response()->json([
            'message' => 'Team Not Found.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(int $id)
    {
        $team = Team::find($id);
        if ($team) {
            if ($this->isAuthorized($team)) {
                $team->delete();
                return response()->json([
                    'message' => 'Deleted.'
                ]);
            }
            return response()->json([
                'message' => 'Not Authorized.'
            ]);
        }

        return response()->json([
            'message' => 'Team not found'
        ]);
    }

    private function isAuthorized(Team $team)
    {
        return Auth::user()->id === $team->user_id;
    }
}
