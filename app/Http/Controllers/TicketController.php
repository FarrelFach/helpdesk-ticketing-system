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
        $tickets = Ticket::with(['creator', 'assignedTo', 'category'])->get();
        return view('ticket.ticket', compact('tickets'));
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
            'judul' => 'required|string|max:255',
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

    public function updateStatus(Ticket $ticket, Request $request)
    {
        $status = $request->input('status');

        // Update the status of the ticket
        $ticket->status = $status;
        $ticket->save();
    
        return response()->json(['success' => true]);
    }
}
