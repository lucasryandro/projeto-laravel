<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HevyController extends Controller
{
    private function getWorkout($page)
    {
        $url = "https://api.hevyapp.com/v1/workouts?page=" . $page . "&pageSize=5";
        $key = env('HEVY_KEY');

        $headers = [
            'api-key' => $key,
            'accept' => 'application/json',
        ];


        $response = Http::withHeaders($headers)->get($url);

        if ($response->successful()) {
            // Retorna a resposta JSON
            return ["status" => true, "data" => $response->json()];
        } else {

            return ["status" => false, "data" => "erro na requisição"];
        }
    }

    public function showWorkouts()
    {
        $id = Session::get('id');

        $workouts = $this->getWorkout($id);

        // return view('showWorkouts');

        if (!$workouts['status']) {
            return view('showWorkouts', ['workouts' => []]);
        }

        return view('showWorkouts', ['workouts' => $workouts['data']["workouts"]]);
    }
}
