<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Category = new Category;
    }

    public function index()
    {
        $ctg = Category::all();
        return view('category.category', compact('ctg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form data (you can add your validation rules here)
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:categories',
            // Add more validation rules if needed
        ]);

        // Insert data into the database
        $category = new Category;
        $category->name = $validatedData['name'];
        $category->save();

        // Return a response (you can customize the response based on your needs)
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Find the ticket by its ID
         $ctg = Category::find($id);

         if (!$ctg) {
             // Handle the case where the ticket does not exist
             Session::flash('error', 'Entry not found');
             return redirect('category');
         }
 
         // Delete the ticket
         $ctg->delete();
 
         Session::flash('success', 'Entry deleted successfully');
         
         return redirect('category');
    }
}
