<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratingbarnew;
use App\Models\Stylist;

class RatingbarnewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'stylist' => 'required|string',
            'comentarios' => 'nullable|string'
        ]);

        $stylist = Stylist::firstOrCreate(['name' => $validatedData['stylist']]);

        $ratingbar = new Ratingbarnew([
            'calificacion' => $validatedData['calificacion'],
            'comentarios' => $validatedData['comentarios']
        ]);

        $stylist->ratings()->save($ratingbar);

        return response([
            'message' => 'Rating saved'
        ], 200);
    }

    public function averageRating($name)
    {
        $stylist = Stylist::where('name', $name)->first();

        if(!$stylist)
        {
            return response([
                'message' => 'Stylist not found.'
            ], 403);
        }

        $averageRating = $stylist->averageRating();

        return response([
            'average_rating' => $averageRating
        ], 200);
    }
}
