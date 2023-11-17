<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Ticket = new Ticket;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $open="Open";
        $close="Closed";
        $pending="Pending";
        $count = Ticket::where('creator_id', Auth::user()->id)->count();
        $countOpen = Ticket::where('status', $open)
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $countClose = Ticket::where('status', $close)
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $countPending = Ticket::where('status', $pending)
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $Ticket = Ticket::all();
        return view('home', compact('Ticket', 'count', 'open', 'close', 'pending', 'countOpen', 'countClose', 'countPending'));
    }

    public function show($status)
    {
        $tkt = Ticket::where('status', $status)->get();;
        return view('ticket.show', compact('tkt'));
    }

    public function fetchData($id)
    {
        $data = Ticket::where('status', $id)
              ->where('creator_id', Auth::user()->id)
              ->get(); // Replace YourModel with your actual Eloquent model.

        return response()->json($data);
    }

    public function fetchDataAll($id)
    {
        $data = Ticket::where('creator_id', $id)->get(); // Replace YourModel with your actual Eloquent model.

        return response()->json($data);
    }
}
