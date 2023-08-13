<?php

namespace App\Http\Controllers\Public;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertySearchController extends Controller
{
    public function __invoke(Request $request)
    {
        return Property::with('city')
            // conditions will come here
            ->when($request->city, function ($query) use ($request) {
                $query->where('city_id', $request->city);
            })
            ->get();
    }
}
