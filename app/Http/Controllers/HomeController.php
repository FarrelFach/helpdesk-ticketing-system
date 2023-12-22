<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $allcount = Ticket::all()->count();
        //admin count
        $allopenCount = Ticket::where('status', 'Open')->count();
        $allinProgressCount = Ticket::where('status', 'In Progress')->count();
        $alltbcCount = Ticket::where('status', 'To Be Confirmed')->count();
        $allclosedCount = Ticket::where('status', 'Closed')->count();
        //usercount
        $openCount = Ticket::where('status', 'Open')->where('creator_id', Auth::user()->id)->count();
        $inProgressCount = Ticket::where('status', 'In Progress')->where('creator_id', Auth::user()->id)->count();
        $tbcCount = Ticket::where('status', 'To Be Confirmed')->where('creator_id', Auth::user()->id)->count();
        $closedCount = Ticket::where('status', 'Closed')->where('creator_id', Auth::user()->id)->count();
                    
        $Ticket = Ticket::with(['creator', 'assignedTo', 'category', 'attachment'])
                    ->orderByRaw("
                    CASE 
                        WHEN status = 'To Be Confirmed...' THEN 1 
                        WHEN status = 'Open' THEN 2 
                        WHEN status = 'In Progress' THEN 3
                        ELSE 4 
                    END
                    ")
                    ->where('creator_id', Auth::user()->id)
                    ->paginate(10);
        $usertickets = Ticket::with(['creator', 'assignedTo', 'category', 'attachment' => function ($query) {
                        $query->whereIn('detail', ['first', 'second']);
                    }])
                    ->whereIn('status', ['Open', 'In Progress', 'Closed', 'To Be Confirmed'])
                    ->where('creator_id', Auth::user()->id)
                    ->orderBy('updated_at')
                    ->orderBy('id')
                    ->paginate(10);

                    $openTickets = $usertickets->filter(function ($ticket) {
                        return $ticket->status === 'Open';
                    });
    
                    $inProgressTickets = $usertickets->filter(function ($ticket) {
                        return $ticket->status === 'In Progress';
                    });

                    $tbcTickets = $usertickets->filter(function ($ticket) {
                        return $ticket->status === 'To Be Confirmed';
                    });
    
                    $closedTickets = $usertickets->filter(function ($ticket) {
                        return $ticket->status === 'Closed';
                    });
        $allTickets = Ticket::with(['creator', 'assignedTo', 'category', 'attachment' => function ($query) {
                        $query->whereIn('detail', ['first', 'second']);
                    }])
                    ->whereIn('status', ['Open', 'In Progress', 'Closed', 'To Be Confirmed'])
                    ->orderBy('updated_at')
                    ->orderBy('id')
                    ->paginate(10);

                $allopenTickets = $allTickets->filter(function ($ticket) {
                    return $ticket->status === 'Open';
                });

                $allinProgressTickets = $allTickets->filter(function ($ticket) {
                    return $ticket->status === 'In Progress';
                });

                $alltbcTickets = $allTickets->filter(function ($ticket) {
                    return $ticket->status === 'To Be Confirmed';
                });

                $allclosedTickets = $allTickets->filter(function ($ticket) {
                    return $ticket->status === 'Closed';
                });
        $Category = Category::all();
        $user = User::all();
        $dataFromDB = Ticket::select('category_id', DB::raw('COUNT(*) as count'))
                        ->groupBy('category_id')
                        ->get();

        return view('home', compact('Ticket', 
        'count', 
        'allcount',
        'allopenCount',
        'allinProgressCount',
        'allclosedCount',
        'alltbcCount',
        'openCount',
        'inProgressCount',
        'closedCount',
        'tbcCount',
        'openTickets',
        'inProgressTickets',
        'tbcTickets',
        'closedTickets',
        'allopenTickets',
        'allinProgressTickets',
        'alltbcTickets',
        'allclosedTickets',
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

    public function fetchTicket($id)
    {
        $tickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('id', $id)
                    ->get();
        return response()->json([$tickets]);
    }
}
