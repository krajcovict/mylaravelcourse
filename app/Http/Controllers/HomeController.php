<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cars = Cache::remember('home-cars', 75, function(){
            return Car::where('published_at', '<', now())
            ->with(['city', 'carType', 'fuelType', 'maker', 'model', 'primaryImage', 'favouredUsers'])
            ->orderBy('published_at','desc')
            ->limit(30)
            ->get();
        });
        return view('home.index', ['cars' => $cars]);
    }
}


