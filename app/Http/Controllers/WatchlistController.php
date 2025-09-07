<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $cars = Auth::user()
        ->favouriteCars()
        ->with(['city', 'carType', 'fuelType', 'maker', 'model', 'primaryImage'])
        ->paginate(15);

        return view('watchlist.index', ['cars' => $cars]);
    }

    public function storeDestroy(Car $car)
    {
        $user = Auth::user();

        $carExists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        if ($carExists) {
            $user->favouriteCars()->detach($car);

            return back()->with('success', 'Car was removed from watchlist.');
        }

        $user->favouriteCars()->attach($car);
        return back()->with('success', 'Car was added to watchlist');
    }
}
