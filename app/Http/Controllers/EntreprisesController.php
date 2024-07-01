<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\entreprises;

class EntreprisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @re
     * turn \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_entreprise', ['only' => ['store']]);
        $this->middleware('permission:modifier_entreprise', ['only' => ['update']]);
        $this->middleware('permission:supprimer_entreprise', ['only' => ['destroy']]);
        $this->middleware('permission:entreprise', ['only' => ['index']]);

    }
    
    public function index()
    {
        $entreprises= entreprises::all();
        return view('entreprises/entreprises',compact('entreprises'));
        
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
            'ice' => 'required|unique:entreprises|max:255',
            'nom' => 'required',
        ], [
            'ice.required' => 'Entrez le ICE du entreprises',
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
          
        $entreprises = entreprises::create([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'image' => $requestData['image'],
        ]);
    }
    else
    {
        $entreprises = entreprises::create([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
         ]);  
    }
        session()->flash('Add', 'l entreprises a été ajouté avec succès');
        return redirect('/entreprises');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\entreprises  $entreprises
     * @return \Illuminate\Http\Response
     */
    public function show(entreprises $entreprises)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\entreprises  $entreprises
     * @return \Illuminate\Http\Response
     */
    public function edit(entreprises $entreprises)
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
    public function update(Request $request, entreprises $entreprises)
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
        //     'ice.required' => 'Entrez le ICE d entreprises',
        //     'nom.required' => 'Entrez le nom',
        //     'infobanque.required' => 'Entrez le prénom',
        //     'siteweb.required' => 'Entrez le site web',
        //     'telephone.required' => 'Entrez le téléphone',
        //     'adresse.required' => 'Entrez l\'adresse',
        //     'email.required' => 'Entrez l\'email'
        // ]);

        $entreprises = entreprises::find($id);
        
        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];

        $entreprises->update([
            'ice' => $request->ice,
            'nom' => $request->nom,
            'infobanque' => $request->infobanque,
            'siteweb' => $request->siteweb,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'image' => $requestData['image']

        ]);
        }
        else
        {
            $entreprises->update([
                'ice' => $request->ice,
                'nom' => $request->nom,
                'infobanque' => $request->infobanque,
                'siteweb' => $request->siteweb,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
     
            ]);

        }
        session()->flash('edit', 'entreprise bien modifié');
        return redirect('/entreprises'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\entreprises  $entreprises
     * @return \Illuminate\Http\Response
     */
    public function destroy(entreprises $entreprises,Request $request)
    {
        $id = $request->id;
        entreprises::find($id)->delete();
        session()->flash('delete','entreprises bien ete supprimée');
        return redirect('/entreprises');
        
    }
}
