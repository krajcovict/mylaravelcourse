<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = User::find(1)
            ->cars()
            ->with(['primaryImage', 'maker', 'model'])
            ->orderBy("created_at", "desc")
            ->paginate(15);
        return view('car.index', ['cars'=> $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'maker_id' => 'required',
            'model_id' => 'required',
            'year' => 'required|integer|min:1900|max:'.date('Y'),
            'car_type_id' => 'required|exists:car_types,id',
            'price' => 'required|integer|min:10',
            'vin' => 'required|string|size:17',
            'mileage' => 'required|integer|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|min:7|max:20',
            'features' => 'array',
            'features.*' => 'string',
            'description' => 'nullable|string|max:3000',
            'published_at' => 'nullable|date',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9024',
        ]);

        $featuresData = $data['features'] ?? [];
        $images = $request->file('images') ?? [];

        $data['user_id'] = 1;

        $car = Car::create($data);

        $car->features()->create($featuresData);

        foreach ($images as $i => $image) {
            $path = $image->store('images');
            $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
        }

        return redirect()->route('car.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        /* if (!$car->published_at) {
            abort(404);
        } */
        $publishedAt = $car->published_at ? Carbon::parse($car->published_at) : null;
        if (!$publishedAt || $publishedAt->isAfter(today())) {
            abort(404);
        }
        return view('car.show', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('car.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
    public function search(Request $request)
    {
        $maker = $request->integer('maker_id');
        $model = $request->integer('model_id');
        $carType = $request->integer('car_type_id');
        $fuelType = $request->integer('fuel_type_id');
        $state = $request->integer('state_id');
        $city = $request->integer('city_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $mileage = $request->integer('mileage');
        $sort = $request->input('sort', '-published_at');



        $query = Car::where('published_at', '<', now())
            ->with(['city', 'carType', 'fuelType', 'maker', 'model', 'primaryImage']);

        if ($maker) {
            $query->where('maker_id', $maker);
        }
        if ($model) {
            $query->where('model_id', $model);
        }
        if ($carType) {
            $query->where('car_type_id', $carType);
        }
        if ($fuelType) {
            $query->where('fuel_type_id', $fuelType);
        }
        if ($state) {
            $query->join('cities', 'cities.id', '=', 'cars.city_id')
            ->where('cities.state_id', $state);
        }
        if ($city) {
            $query->where('city_id', $city);
        }
        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }
        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }
        if ($mileage) {
            $query->where('mileage', '<=', $mileage);
        }

        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1);
            $query->orderBy($sort, 'desc');
        } else {
            $query->orderBy($sort);
        }

        $cars = $query->paginate(15)
        ->withQueryString();

        return view('car.search', ['cars' => $cars]);
    }

    public function watchlist()
    {
        // TODO Make real user finding
        $cars = User::find(4)->favouriteCars()
        ->with(['city', 'carType', 'fuelType', 'maker', 'model', 'primaryImage'])
        ->paginate(15);

        return view('car.watchlist', ['cars' => $cars]);


    }
}
