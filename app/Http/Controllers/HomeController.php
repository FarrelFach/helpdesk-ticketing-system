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
        $count = Ticket::where('creator_id', Auth::user()->id)->count();
        $countOpen = Ticket::where('status', 'Open')
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $countClose = Ticket::where('status', 'Closed')
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $countProgress = Ticket::where('status', 'In Progress')
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $countTBC = Ticket::where('status', 'To Be Confirmed')
                    ->where('creator_id', Auth::user()->id)
                    ->count();
        $Ticket = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->orderByRaw("
                    CASE 
                        WHEN status = 'To Be Confirmed...' THEN 1 
                        WHEN status = 'Open' THEN 2 
                        WHEN status = 'In Progress' THEN 3
                        ELSE 4 
                    END
                    ")
                    ->get();
        $opentickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'Open')
                    ->get();
        $progresstickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'In Progress')
                    ->get();
        $closedtickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'Closed')
                    ->get();
        $tbctickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'To Be Confirmed')
                    ->get();
        return view('home', compact('Ticket', 
        'count', 
        'countOpen', 
        'countClose', 
        'countProgress', 
        'countTBC', 
        'opentickets', 
        'progresstickets',
        'closedtickets', 
        'tbctickets',));
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

    public function updateTicket(Request $request, $ticketId)
    {
        try{
            $status = $request->input('status');
            $ticket = Ticket::findOrFail($ticketId);
            // Update the status of the ticket
            $ticket->status = $status;
            $ticket->save();
    
            return response()->json(['updatedStatus' => $ticket->status]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e);
            return response()->json(['error' => 'An error occurred while updating the ticket status.']);
        }
    }
}
