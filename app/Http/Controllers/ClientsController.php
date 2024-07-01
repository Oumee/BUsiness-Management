<?php

namespace App\Http\Controllers;

use App\Models\clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_client', ['only' => ['store']]);
        $this->middleware('permission:modifier_client', ['only' => ['update']]);
        $this->middleware('permission:supprimer_client', ['only' => ['destroy']]);
        $this->middleware('permission:client', ['only' => ['index']]);
         
    }
    
    
    public function index()
    {
        $clients = clients::all();
   return view('clients/clients',compact('clients'));

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
            'cin'=>'required|unique:clients|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            
            
        ],[
            'cin.required' => 'Entrer le cin du client',
            'cin.unique' => 'Le cin déjè existe',
            'nom.required' => 'Entrer le nom',
            'prenom.required' => 'Entrer le prenom',
             
        ]); 
 
        $requestData = $request->all();

        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];
        
        $clients = new clients();
        $clients->cin= $request->cin;
        $clients->nom= $request->nom;
        $clients->prenom= $request->prenom;
        $clients->telephone= $request->telephone;
        $clients->adresse= $request->adresse;
        $clients->email= $request->email;
        $clients->image= $requestData['image'];
        $clients->save();
        
        }
        else
        {
            $clients = new clients();
            $clients->cin= $request->cin;
            $clients->nom= $request->nom;
            $clients->prenom= $request->prenom;
            $clients->telephone= $request->telephone;
            $clients->adresse= $request->adresse;
            $clients->email= $request->email;
             $clients->save();
        }
        session()->flash('Add','le client est bien ajouté');
        echo $clients;
        return  redirect('/clients');
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clients $clients)
    {
        $id = $request->id;
         
    //    $request->validate([
    //         'cin' => 'required|unique:clients,cin,' . $id . '|max:255',
    //         'nom' => 'required|unique:clients,nom,' . $id ,
    //         'prenom' => 'required',
    //         'telephone' => 'required',
    //         'adresse' => 'required',
    //         'email' => 'required'
    //     ],[
    //         'cin.required' => 'Entrer le cin du client',
    //         'cin.unique' => 'Le cin déjà existe',
    //         'nom.unique' => 'Le nom déjà existe',
    //         'nom.required' => 'Entrer le nom',
    //         'prenom.required' => 'Entrer le prénom',
    //         'telephone.required' => 'Entrer le téléphone',
    //         'adresse.required' => 'Entrer l\'adresse',
    //         'email.required' => 'Entrer l\'email'
    //     ]); 
    
        $clients = clients::find($id);
        if ($request->hasFile('image'))  
        {
    
        $fileName = time().$request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images',$fileName,'public');
        $requestData['image'] = '/storage/' . $path;
        echo  $requestData['image'];

        $clients->update([
            'cin' => $request->cin,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'image' => $requestData['image']
        ]);
        }
        else
        {
            $clients->update([
                'cin' => $request->cin,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'email' => $request->email,
                             ]);
     

        }
        session()->flash('edit', 'Client bien modifié');
        return redirect('/clients'); 
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,clients $clients)
    {
        $id = $request->id;
        clients::find($id)->delete();
        session()->flash('delete',' suppression du client  avec succes');
        return redirect('/clients');
    }
}
