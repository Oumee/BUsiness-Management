<?php

namespace App\Http\Controllers;

use App\Models\classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_categorie', ['only' => ['store']]);
        $this->middleware('permission:modifier_categorie', ['only' => ['update']]);
        $this->middleware('permission:supprimer_categorie', ['only' => ['destroy']]);
        $this->middleware('permission:categorie', ['only' => ['index']]);
   
    }
    
    public function index()
    {
        $classes = classes::all();
        return view('classes/classes',compact('classes'));
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
         
        
        $request->validate([
            'section_name'=>'required|unique:classes|max:255',
         ],[
            'section_name.required' => 'Entrer le nom de la catégorie',
            'section_name.unique' => 'La classe déjè existe',
         ]); 
           
        
     
        $requestData = $request->all();

        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];

        $classe = new classes();
        $classe->section_name= $request->section_name;
        $classe->description= $request->description;
        $classe->Created_by= (Auth::user()->name);
        $classe->image=  $requestData['image'];
        $classe->save();
      
     
    } else
    {
       
        $classe = new classes();
        $classe->section_name= $request->section_name;
        $classe->description= $request->description;
        $classe->Created_by= (Auth::user()->name);
         $classe->save(); 
    }
    session()->flash('Add','la classe est bien ajoutée');
    return  redirect('/classes');
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(classes $classes,Request $request)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, classes $classes)
    {
       
        $id = $request->id;

        

        $sections = classes::find($id);
          
    $requestData = $request->all();

    if ($request->hasFile('image'))  
    {

    $fileName = time().$request->file('image')->getClientOriginalName();
    $path = $request->file('image')->storeAs('images',$fileName,'public');
    $requestData['image'] = '/storage/' . $path;
    echo  $requestData['image'];
    $sections->update([
        'section_name' => $request->section_name,
        'description' => $request->description,
        'image' => $requestData['image'],
    ]);
        
        
      
    }else{
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
    }

       

        session()->flash('edit','Catégorie est bien modifiée ');
        return redirect('/classes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,classes $classes)
    {
        $id = $request->id;
        classes::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/classes');
    }
}
