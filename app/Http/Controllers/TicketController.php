<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

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
        $opentickets = Ticket::with(['creator', 'assignedTo', 'category', 'attachment'])
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
                    ->paginate(10);
        $takentickets = Ticket::with(['creator', 'assignedTo', 'category', 'attachment'])
                    ->where(function($query) {
                        $query->where('status', 'In Progress')
                              ->where('assigned_to', Auth::user()->id);
                    })
                    ->orWhere(function($query) {
                        $query->where('status', 'To Be Confirmed')
                              ->where('assigned_to', Auth::user()->id);
                    })
                    ->orderByRaw("
                    CASE 
                        WHEN priority = 'To Be Confirmed' THEN 1 
                        WHEN priority = 'In Progress' THEN 2
                        ELSE 4 
                    END
                    ")
                    ->orderBy('id')
                    ->paginate(10);
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
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $validatedData = $request->validate([
            'judul' => 'required|string|max:20',
            'description' => 'required',
            'prioritas' => 'required',
            'image1' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // Validation for image and PDF
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

        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Determine the file type (extension) of the uploaded image
            $fileType = $image->getClientOriginalExtension(); // This retrieves the file extension
        
            // Resize and compress the uploaded image
            if ($fileType !== 'pdf') {
                $resizedImage = Image::make(public_path('images') . '/' . $imageName);
                $resizedImage->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $resizedImage->save(public_path('images') . '/' . $imageName, 60); // Compress image to 60% quality
            }
            // Save image details in the database
            $imageModel = new Attachment();
            $imageModel->ticket_id = $tkt->id;
            $imageModel->image_url = $imageName;
            $imageModel->uploaded_by = Auth::user()->id;
            $imageModel->file_type = $fileType;
            $imageModel->detail = 'first';
            $imageModel->save();
        }
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
            if (!$ticket) {
                return response()->json([
                    'updatedStatus' => $ticket->status,
                    'updatedAssigned' => $ticket->creator->name,
                ]);
            }
            // Update the status of the ticket
            if ($ticket->status === 'Open' && $status === "In Progress"){
                $ticket->status = $status;
                $ticket->assigned_to = $assignee;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $detail = 'ticket taken';
            } //take
            else if ($ticket->status === 'In Progress' && $status === null){
                $ticket->assigned_to = $assignee;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $detail = 'ticket taken over';
            } //takeover
            else if ($ticket->status === 'In Progress' && $status === 'Open'){
                $ticket->status = $status;
                $ticket->assigned_to = null;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $detail = 'ticket taken over';
            } //Untake
            else {
                $ticket->status = $status;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $detail = 'ticket done or accepted';
            }
            $ticket->save();
            return response()->json([
                'newStatus' => $ticket->status,
                'newAssignee' => $ticket->assignedTo->name,
                'detail' => $detail
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e);
            return response()->json(['error' => 'An error occurred while updating the ticket status.', 'Comment' => $comment,]);
        }
    }

    Public function solve(Request $request, $ticketId)
    {
        try{
            $status = $request->input('status');
            $assignee = $request->input('assignee');
            $comments = $request->comment;
            $ticket = Ticket::with(['creator', 'assignedTo', 'category'])
                            ->findOrFail($ticketId);
            if (!$ticket) {
                return response()->json([
                    'updatedStatus' => $ticket->status,
                    'updatedAssigned' => $ticket->creator->name,
                ]);
            }
            // Update the status of the ticket
            if ($ticket->status === 'To Be Confirmed' && $status === "In Progress"){
                $ticket->status = $status;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $comment = new Comment;
                $comment->ticket_id = $ticket->id;
                $comment->user_id = Auth::user()->id;
                $comment->comment_text = $comments;
                $comment->comment_type = "1";
                $comment->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $comment->save();

                $detail = 'ticket denied';
            } //denied
            else if ($ticket->status === 'In Progress' && $status === 'To Be Confirmed'){
                $ticket->status = $status;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                
                $comment = new Comment;
                $comment->ticket_id = $ticket->id;
                $comment->user_id = Auth::user()->id;
                $comment->comment_text = $comments;
                $comment->comment_type = "2";
                $comment->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $comment->save();

                $detail = 'ticket done';
            } //Solve
            else {
                $ticket->status = $status;
                $ticket->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $detail = 'ticket done or accepted';
            } //acception
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
    
                // Determine the file type (extension) of the uploaded image
                $fileType = $image->getClientOriginalExtension(); // This retrieves the file extension
            
                // Resize and compress the uploaded image
                if ($fileType !== 'pdf') {
                    $resizedImage = Image::make(public_path('images') . '/' . $imageName);
                    $resizedImage->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $resizedImage->save(public_path('images') . '/' . $imageName, 60); // Compress image to 60% quality
                }
                // Save image details in the database
                $imageModel = new Attachment();
                $imageModel->ticket_id = $ticket->id;
                $imageModel->image_url = $imageName;
                $imageModel->uploaded_by = Auth::user()->id;
                $imageModel->file_type = $fileType;
                $imageModel->detail = 'second';
                $imageModel->save();
            }
            $ticket->save();
            return response()->json([
                'newStatus' => $ticket->status,
                'newAssignee' => $ticket->assignedTo->name,
                'detail' => $detail
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e);
            return response()->json(['error' => 'An error occurred while updating the ticket status.', 'Comment' => $comment,]);
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

    public function getTicketDetails($ticketId)
    {
        $images = Attachment::where('ticket_id', $ticketId)
                            ->where('detail', 'first')
                            ->first();

        return response()->json([
            'file_type' => $images->file_type,
            'image_url' => asset('images/' . $images->image_url)
        ]);
    }

    public function getTicketSolves($ticketId)
    {
        $images = Attachment::where('ticket_id', $ticketId)
                            ->where('detail', 'second')
                            ->first();

        return response()->json([
            'file_type' => $images->file_type,
            'image_url' => asset('images/' . $images->image_url)
        ]);
    }


    public function getComments($ticketId)
    {
        $comments_denied = Comment::with(['user', 'ticket'])
                            ->where('ticket_id', $ticketId)
                            ->where('comment_type', '1')
                            ->get();
        
        $comments_solve = Comment::with(['user', 'ticket'])
                            ->where('ticket_id', $ticketId)
                            ->where('comment_type', '2')
                            ->get();

        return response()->json([
            'comments_denied' => $comments_denied,
            'comments_solve' => $comments_solve,
        ]);
    }
}
