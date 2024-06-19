<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $terbaru = Place::with('placeDetails')->orderBy('id', 'desc')->limit(4)->get();
        $termurah = Place::with('placeDetails')->orderBy('price', 'asc')->limit(4)->get();
        $termahal = Place::with('placeDetails')->orderBy('price', 'desc')->limit(4)->get();
        return view('frontend/index', [
            'terbaru' => $terbaru,
            'termurah' => $termurah,
            'termahal' => $termahal,
        ]);
    }

    public function detail($id)
    {
        $detail = Place::with('placeDetails')->where('id', $id)->first();
        return view('frontend/product-details', [
            'detail' => $detail,
        ]);
    }

    public function product()
    {
        $data = Place::with('placeDetails')->orderBy('id', 'desc')->simplePaginate(8);
        return view('frontend/product', [
            'data' => $data
        ]);
    }

    public function login()
    {
        return view('frontend/auth/login');
    }

    public function register()
    {
        return view('frontend/auth/register');
    }
}
