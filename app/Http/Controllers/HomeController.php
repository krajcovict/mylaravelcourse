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

class HomeController extends Controller
{
    public function index()
    {
        /* $cars = Car::where('published_at', '!=', 'null')
            ->orderBy('created_at')
            ->limit(20)
            ->get();
        dump($cars); */

        /* $carData = [
            'maker_id' => 1,
            'model_id' => 1,
            'year' => 2024,
            'price' => 20000,
            'vin' => 'JH4NA1260MT001906',
            'mileage' => 5000,
            'car_type_id' => 1,
            'fuel_type_id' => 1,
            'user_id' => 1,
            'city_id' => 1,
            'address' => 'Something',
            'phone' => '999',
            'description' => null,
            'published_at' => now(),
        ];

        /* // Create and return record
        $car2 = Car::create($carData);

        // Or create a model, fill with data and then save in DB
        $car2 = new Car();
        $car2->fill($carData);
        $car2->save(); */

        /*  Or
        $car3 = new Car($carData);
        $car3->save(); */

        /* $cars = Car::where('price', '>', 20000)->get();
        dump($cars);

        Car::where('published_at', '=', null)
            ->where('user_id', 1)
            ->update(['published_at' => now()]); */

        /* $car = Car::find(1);
        dump($car->images); */

        /* $maker = Maker::factory()->create();
        dump($maker); */

        /* Maker::factory()
            ->count(5)
            ->hasModels(3)
            ->create(); */

        /* User::factory()
            ->has(Car::factory()->count(5), 'favouriteCars')
            ->create(); */

        return view('home.index');
    }
}


