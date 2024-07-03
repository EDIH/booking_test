<?php

namespace App\Http\Controllers;

use App\Models\Room;
//use Illuminate\Database\Eloquent\Casts\Json;
//use Illuminate\Http\Request;
use App\Http\Requests\RoomSearchRequest;
use App\Repositories\RoomRepository;

class RoomController extends Controller
{

    public function __construct(
        protected RoomRepository $roomRepository,
    ) {}

    public function search(RoomSearchRequest $request)
    {
        return $this->roomRepository->search(collect($request->validated()));
    }
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
//    public function show(string $id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(string $id)
//    {
//        //
//    }
}
