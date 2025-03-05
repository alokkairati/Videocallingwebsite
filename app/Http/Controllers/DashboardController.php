<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $number = Meeting::where('user_id', Auth()->user()->id)->latest()->first();
        $num = $number->id ?? 1;
        $randomNumber = str_pad(Auth()->user()->id . $num + 1, 4, '0', STR_PAD_RIGHT);
        $userId = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        return view('pages.dashboard',compact('userId'));
    }
}
