<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class RoomRepository
{
    /**
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function search(\Illuminate\Support\Collection $request): Collection
    {
        $query = Room::query();

        $query->when($request-> has('name'), function ($q) use ($request) {
            $q->where('name', 'like', "%{$request['name']}%");
        });

        $query->when($request-> has('bedrooms'), function ($q) use ($request) {
            $q->where('bedrooms', $request['bedrooms']);
        });

        $query->when($request-> has('bathrooms'), function ($q) use ($request) {
            $q->where('bathrooms', $request['bathrooms']);
        });

        $query->when($request-> has('storeys'), function ($q) use ($request) {
            $q->where('storeys', $request['storeys']);
        });

        $query->when($request-> has('garages'), function ($q) use ($request) {
            $q->where('garages', $request['garages']);
        });

//        $query->when($request-> has(['price.min', 'price.max']), function ($q) use ($request) {
//            $q->where('garages', $request['garages']);
//        });

        $rooms = $query->get();

        return $rooms;
    }
}
