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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Team::paginate(5);

        // with sorting
        // $sortColumn = $request->input('sort', 'name');
        // $sortDirection = startsWith($sortColumn, '-') ? 'desc' : 'asc';
        // $sortColumn = ltrim($sortColumn, '-');

        // return Team::orderBy($sortColumn, $sortDirection)
        //     ->paginate(5);

        // with sorting using multiple columns
        // $sorts = explode(',', $request->input('sort', ''));
        // $teams = Team::query();

        // foreach ($sorts as $sortColumn) {
        //     $sortDirection = startsWith($sortColumn, '-') ? 'desc' : 'asc';
        //     $sortColumn = ltrim($sortColumn, '-');

        //     $teams->orderBy($sortColumn, $sortDirection);
        // }

        // return $teams->paginate(5);

        // with filtering
        // $query = Team::query();

        // $query->when($request->filled('filter'), function ($query) {
        //     // with single filter
        //     [$criteria, $value] = explode(':', $request('filter'));
        //     return $query->where($criteria, $value);

        //     // with multiple filters
        //     $filters = explode(',', $request('filter'));
        //     foreach ($filters as $filter) {
        //         [$criteria, $value] = explode(':', $filter);
        //         $query->where($criteria, $value);
        //     }

        //     return $query;
        // });
        // return $query->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $request->validated();

        if (Auth::user()->team) {
            return $this->error('', 'A user can only have one team', 403);
        }

        $team = Team::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'body' => $request->body
        ]);

        return new TeamsResource($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return new TeamsResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(StoreTeamRequest $request, $id)
    {
        $team = Team::find($id);
        if ($team){
            $team->update($request->validated());
            return $this->isNotAuthorized($team) ?: new TeamsResource($team);
        }
        return response()->json('Team not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        return $this->isNotAuthorized($team) ? $this->isNotAuthorized($team) : $team->delete();
    }

    private function isNotAuthorized($team)
    {
        if (Auth::user()->id !== $team->user_id) {
            return $this->error('', 'Unauthorized to take action on this team', 403);
        }
    }
}
