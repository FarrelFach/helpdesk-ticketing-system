<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $countClosed = Ticket::where('status', 'Closed')
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
                    ->where('creator_id', Auth::user()->id)
                    ->get();
        $opentickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'Open')
                    ->where('creator_id', Auth::user()->id)
                    ->get();
        $progresstickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'In Progress')
                    ->where('creator_id', Auth::user()->id)
                    ->get();
        $closedtickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'Closed')
                    ->where('creator_id', Auth::user()->id)
                    ->get();
        $tbctickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'To Be Confirmed')
                    ->where('creator_id', Auth::user()->id)
                    ->get();
        $Category = Category::all();
        $user = User::all();
        $dataFromDB = Ticket::select('category_id', DB::raw('COUNT(*) as count'))
                        ->groupBy('category_id')
                        ->get();

        return view('home', compact('Ticket', 
        'count', 
        'countOpen', 
        'countClosed', 
        'countProgress', 
        'countTBC', 
        'opentickets', 
        'progresstickets',
        'closedtickets', 
        'tbctickets',
        'user',
        'Category',
        'dataFromDB'
    ));
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

    public function updateTicket(Request $request, $id)
    {
        try{
            $status = $request->input('status');
            $ticket = Ticket::with(['creator', 'assignedTo', 'category'])
                            ->where("id", $id)
                            ->first();

            if (!$ticket) {
                return response()->json([
                    'error' => 'Ticket not found', 
                    'id' => $ticketId,
                    'status' => $status
                ]);
            }
            // Update the status of the ticket
            if ($status === "Open"){
                $ticket->status = $status;
                $ticket->assigned_to = null;
            }
            else {
                $ticket->status = $status;
            }
            $ticket->save();

            return response()->json($ticket);
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error($e);
            return response()->json(['error' => 'An error occurred while updating the ticket status.']);
        }
    }

    public function fetchTicket($id)
    {
        $tickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('id', $id)
                    ->get();
        return response()->json([$tickets]);
    }
}
