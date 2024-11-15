<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getAge(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $response = Http::get(sprintf('https://api.agify.io/?name=%s', $validated['name']));

        $age = $response->json('age');

        return response()->json([
            'age' => $age,
        ]);
    }
}
