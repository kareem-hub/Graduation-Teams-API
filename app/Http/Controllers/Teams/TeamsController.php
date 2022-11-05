<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
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
     */
    public function index()
    {
        $result = Team::paginate(5);
        if ($result->isEmpty()){
            return response()->json([
                'message' => 'No teams yet.'
            ], 404);
        }
        return response()->json([
            'teams' => TeamsResource::collection($result)
        ], 200);
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
                'message' => 'User with ID: ' . $request->user()->id . ' already has a team.'
            ], 403);
        }

        $request->validated();

        $team = Team::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'body' => $request->body,
        ]);

        return response()->json([
            'message' => 'Created.',
            'team' => new TeamsResource($team)
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
            return response()->json([
                'team' => new TeamsResource($team)
            ], 200);
        }
        return response()->json([
            'message' => 'Team not found.'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     */
    public function update(UpdateTeamRequest $request, int $id)
    {
        $team = Team::find($id);
        if ($team) {
            if ($this->isAuthorized($request, $team)) {
                $team->update($request->validated());
                return response()->json([
                    'message' => 'Updated.',
                    'team' => new TeamsResource($team)
                ], 200);
            }
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        return response()->json([
            'message' => 'Team Not Found.'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(Request $request, int $id)
    {
        $team = Team::find($id);
        if ($team) {
            if ($this->isAuthorized($request, $team)) {
                $team->delete();
                return response()->json([
                    'message' => 'Deleted.'
                ], 200);
            }
            return response()->json([
                'message' => 'Not Authorized.'
            ], 401);
        }

        return response()->json([
            'message' => 'Team not found.'
        ], 404);
    }

    private function isAuthorized(Request $request = null, Team $team)
    {
        return $request->user()->id === $team->user_id;
    }
}
