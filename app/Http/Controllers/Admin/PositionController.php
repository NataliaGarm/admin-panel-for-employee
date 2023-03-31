<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Support\Facades\Auth;
use App\DataTables\PositionsDataTable;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PositionsDataTable $dataTable)
    {
       /* $positions = Position::all();
        return view('admin.positions.index', [
            'positions' => $positions,
        ]);*/

        return $dataTable->render('admin.positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionRequest $request)
    {
        $user_id = $this->getUserId();
        $position = new Position();

        $position->name = $request->input('name');
        $position->admin_created_id = $user_id;
        $position->admin_updated_id = $user_id;

        $position->save();

        return redirect('positions')->withSuccess('Position added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('admin.positions.show', [
            'position' => $position,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('admin.positions.edit', [
            'position' => $position,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePositionRequest  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $user_id = $this->getUserId();
        $position->name = $request->input('name');
        $position->admin_created_id = $request->input('admin_created_id');
        $position->admin_updated_id = $user_id;

        $position->save();

        return redirect('positions')->withSuccess('Position updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if ($position->employees()->count()) {
            return back()->withErrors(['error' => 'Cannot delete, position has employees']);
        }
        $position->delete();

        return redirect()->back()->withSuccess('Position deleted successfully');
    }

    private function getUserId()
    {
        if (Auth::check()) {
            return Auth::id();
        }

        return redirect("login")->withErrors(trans('auth.failed'));
    }
}
