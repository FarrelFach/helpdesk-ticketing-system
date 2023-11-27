<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Ticket;
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
                    ->get();
        return view('ticket.ticket', compact('opentickets', 'takentickets'));
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
        $tkt->created_by = Auth::user()->name;
        $tkt->status = "Open";
        $tkt->created_at = $currentDate;
        $tkt->save();

        Session::flash('success', 'Data berhasil ditambah');

        return redirect('ticket');
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
        return view('ticket.tiket', compact('Ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
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
}
