<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Ticket = new Ticket;
    }

    public function index()
    {
        $Category = Category::all();
        $user = User::all();
        $opentickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'Open')
                    ->orderByRaw("
                    CASE 
                        WHEN priority = 'High' THEN 1 
                        WHEN priority = 'Medium' THEN 2 
                        WHEN priority = 'Low' THEN 3 
                        ELSE 4 
                    END
                    ")
                    ->orderBy('id')
                    ->get();
        $takentickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('status', 'In Progress')
                    ->orWhere('status', 'To Be Confirmed')
                    ->where('assigned_to', Auth::user()->id)
                    ->orderByRaw("
                    CASE 
                        WHEN priority = 'To Be Confirmed' THEN 1 
                        WHEN priority = 'In Progress' THEN 2
                        ELSE 4 
                    END
                    ")
                    ->orderBy('id')
                    ->get();
        return view('ticket.ticket', compact('opentickets', 'takentickets', 'Category', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tkt = new Ticket;
        return view('Ticket.add', compact('tkt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $validatedData = $request->validate([
            'judul' => 'required|string|max:20',
            'description' => 'required',
            'prioritas' => 'required',
        ]);
        $tkt = new Ticket;
        $tkt->title = $validatedData['judul'];
        $tkt->description = $validatedData['description'];
        $tkt->priority = $validatedData['prioritas'];
        $tkt->creator_id = Auth::user()->id;
        $tkt->category_id = $request->category;
        $tkt->status = "Open";
        $tkt->created_at = $currentDate;
        $tkt->updated_at = $currentDate;
        $tkt->save();

        Session::flash('success', 'Data berhasil ditambah');

        return response()->json($tkt);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $Ticket = Ticket::find($ticket);
        return response()->json(['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $ticket = Ticket::with(['creator', 'assignedTo', 'category'])->find($ticket->id);
        $Category = Category::all();
        $user = User::all();
        return view('ticket.edit', compact('ticket', 'Category', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ticket)
    {
        $Ticket = Ticket::find($ticket);
        $Ticket->title = $request->title;
        $Ticket->description = $request->description;
        $Ticket->category = $request->category;
        $Ticket->priority = $request->priority;
        $Ticket->deparment = $request->department;
        $Ticket->assigned_to = $request->department;
        $Ticket->updated_at = Carbon::now()->format('Y-m-d');
        $Ticket->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            // Find the ticket by its ID
        $ticket = Ticket::find($id);

        if (!$ticket) {
            // Handle the case where the ticket does not exist
            Session::flash('error', 'Ticket not found');
            return redirect('ticket');
        }

        // Delete the ticket
        $ticket->delete();

        Session::flash('success', 'Ticket deleted successfully');
        
        return redirect('ticket');
    }

    public function updateTicket(Request $request, $ticketId)
    {
        try{
            $status = $request->input('status');
            $assignee = $request->input('assignee');
            $ticket = Ticket::with(['creator', 'assignedTo', 'category'])
                            ->findOrFail($ticketId);
            // Update the status of the ticket
            if ($ticket->assigned_to !== null){
                $ticket->status = $status;
                $ticket->updated_at = Carbon::now()->format('Y-m-d');
            }
            else {
                $ticket->status = $status;
                $ticket->assigned_to = $assignee;
                $ticket->updated_at = Carbon::now()->format('Y-m-d');
            }
            $ticket->save();

            return response()->json([
                'updatedStatus' => $ticket->status,
                'updatedAssigned' => $ticket->creator->name,
                'cekingIn' => "if you are reading this, it is a success"
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e);
            return response()->json(['error' => 'An error occurred while updating the ticket status.']);
        }
    }
    

    public function openAll()
    {
            // Find the ticket by its ID
        $ticketsInProgress = Ticket::whereNot('status', 'Open')->get();
        foreach ($ticketsInProgress as $ticket) {
            $ticket->status = 'Open';
            $ticket->save();
        }
        return redirect('ticket');
    }

    public function empty()
    {
        // empty ticket table
        Ticket::truncate();
        return redirect('ticket');
    }

    public function fetchTicket(Request $request, $id)
    {
        $tickets = Ticket::with(['creator', 'assignedTo', 'category'])
                    ->where('id', $id)
                    ->get();
        return response()->json($tickets);
    }
}
