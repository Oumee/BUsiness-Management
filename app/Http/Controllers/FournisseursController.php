<?php

namespace App\Http\Controllers;

use App\Models\fournisseurs;
use Illuminate\Http\Request;

class FournisseursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:ajouter_fournisseur', ['only' => ['store']]);
        $this->middleware('permission:modifier_fournisseur', ['only' => ['update']]);
        $this->middleware('permission:supprimer_fournisseur', ['only' => ['destroy']]);
        $this->middleware('permission:fournisseur', ['only' => ['index']]);

    }
    
    public function index()
    {
        $fournisseurs= fournisseurs::all();
        return view('fournisseurs/fournisseurs',compact('fournisseurs'));
        
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
            'ice' => 'required|unique:fournisseurs|max:255',
            'nom' => 'required',
        ], [
            'ice.required' => 'Entrez le ICE du fournisseur',
            'ice.unique' => 'Ce ICE existe déjà',
            'nom.required' => 'Entrez le nom',
        ]);
        $requestData = $request->all();

        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];
        
        
        $fournisseur = fournisseurs::create([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'image' =>$requestData['image'],
        ]);
        
    }else
    {
        $fournisseur = fournisseurs::create([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
         ]);
           
    }
        session()->flash('Add', 'Le fournisseur a été ajouté avec succès');
        return redirect('/fournisseurs');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fournisseurs  $fournisseurs
     * @return \Illuminate\Http\Response
     */
    public function show(fournisseurs $fournisseurs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fournisseurs  $fournisseurs
     * @return \Illuminate\Http\Response
     */
    public function edit(fournisseurs $fournisseurs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fournisseurs  $fournisseurs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fournisseurs $fournisseurs)
    {
        $id = $request->id;
         
        // $request->validate([
        //     'ice' => 'required|max:255',
        //     'nom' => 'required',
        //     'infobanque' => 'required',
        //     'siteweb' => 'required',
        //     'telephone' => 'required',
        //     'adresse' => 'required',
        //     'email' => 'required'
        // ], [
        //     'ice.required' => 'Entrez le ICE du fournisseur',
        //     'nom.required' => 'Entrez le nom',
        //     'infobanque.required' => 'Entrez le prénom',
        //     'siteweb.required' => 'Entrez le site web',
        //     'telephone.required' => 'Entrez le téléphone',
        //     'adresse.required' => 'Entrez l\'adresse',
        //     'email.required' => 'Entrez l\'email'
        // ]);

        $fournisseurs = fournisseurs::find($id);
        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];

        $fournisseurs->update([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'image' => $requestData['image']

        ]);
    
    }else
    {
        $fournisseurs->update([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
 

        ]);
    
    }
        session()->flash('edit', 'Fournisseurs bien modifié');
        return redirect('/fournisseurs'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fournisseurs  $fournisseurs
     * @return \Illuminate\Http\Response
     */
    public function destroy(fournisseurs $fournisseurs,Request $request)
    {
        $id = $request->id;
        fournisseurs::find($id)->delete();
        session()->flash('delete','Fournisseurs bien ete supprimée');
        return redirect('/fournisseurs');
        
    }
}
