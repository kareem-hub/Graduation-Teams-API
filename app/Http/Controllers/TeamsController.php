<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Http\Traits\HttpResponses;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        $teams = Team::where('type', $request->type ?: 'general')
            ->get();

        if ($teams->isEmpty()) {
            return response()->json([
                'message' => 'no teams yet.'
            ], 404);
        }

        return response()->json([
            'message' => 'success.',
            'teams' => TeamResource::collection($teams)
        ], 200);
    }


    public function store(StoreTeamRequest $request)
    {
        // new comment for the new branch
        if ($request->user()->team) {
            return response()->json([
                'message' => 'user already has a team'
            ], 403);
        }

        $team = $request->user()->team()->create($request->validated());

        return response()->json([
            'message' => 'team created.',
            'team' => new TeamResource($team)
        ], 200);
    }


    public function show(int $team_id)
    {
        $team = Team::find($team_id);

        try {
            return response()->json([
                'team' => new TeamResource($team)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'team not found.'
            ], 404);
        }
    }


    public function update(UpdateTeamRequest $request, int $team_id)
    {
        $team = Team::find($team_id);

        try {
            if ($this->isAuthorized($request, $team)) {
                $team->update($request->validated());
                return response()->json([
                    'message' => 'team updated.',
                    'team' => new TeamResource($team)
                ], 200);
            } else {
                return response()->json([
                    'message' => 'unauthorized.'
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'team not found.'
            ], 404);
        }
    }


    public function destroy(Request $request, int $team_id)
    {
        $team = Team::find($team_id);

        try {
            if ($this->isAuthorized($request, $team)) {
                $team->delete();
                return response()->json([
                    'message' => 'team deleted.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'unauthorized.'
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'team not found.'
            ], 404);
        }
    }

    private function isAuthorized(Request $request = null, Team $team = null)
    {
        return $team ? $request->user()->id === $team->user_id : null;
    }
}
