<?php

namespace App\Http\Controllers;

use App\Notifications\Devis;
use App\Models\ventes;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\DB;
 use App\Models\User;
 use App\Models\products;
 use App\Notifications\facture;
 use App\Notifications\AlertNotification;
 use App\Models\classes;
 use App\Models\transaction_ventes;
 use App\Models\clients;
 use App\Models\entreprises;
 use App\Models\factures;
 use Illuminate\Support\Facades\Notification;

class DevisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_devis', ['only' => ['store']]);
        $this->middleware('permission:modifier_devis', ['only' => ['update','show']]);
        $this->middleware('permission:supprimer_devis', ['only' => ['destroy']]);
        $this->middleware('permission:devis', ['only' => ['index','afficher']]);

    }
    
    public function index()
    { 
        $transaction_ventes = transaction_ventes::all();
        $ventes = ventes::where('devis',1)->get();
        $products = products::all();
        $classes = classes::all();
        $clients = clients::all();
        $entreprises = entreprises::all();
        return view('devis.devis',compact('ventes','products','classes','clients','transaction_ventes','entreprises'));
   
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
            'date' => 'date',
            'total_ht' => 'required',
            'total_ttc' => 'required',
            'client_id' => 'required'
       ], [
            'date.required' => 'Veuillez entrer la date',
            'client_id.required' => 'Veuillez entrer le client',
            'total_ht.required' => 'Le total HT n\'ont entrés' ,
            'total_ttc.required' => 'Le total TTC n\'ont entrés' 
       ]); 
       
       DB::beginTransaction();

       $ventes = new ventes();
       $ventes->date = $request->date;
       $ventes->total_ht = $request->total_ht;
       $ventes->total_ttc = $request->total_ttc;
       $ventes->client_id = $request->client_id;
       $ventes->devis = 1;
       $ventes->save();
       $vente_id = $ventes->id;

    for( $i=2; $i<=100 ; $i++ )
   {  
    // designation
    $id_produit =$request->input('product_'.$i);

    if($id_produit)
    {
 
        
        $transaction_ventes = new transaction_ventes();
        $transaction_ventes->vente_id=  $vente_id;
        $transaction_ventes->product_id=  $id_produit;
        $transaction_ventes->prix_vente = $request->input('prix_vente_'.$i);
        $transaction_ventes->quantite = $request->input('quantite_'.$i);
        $transaction_ventes->save();

  
    }

 

}
    
 
DB::commit();
session()->flash('Add', 'Le devis a bien été ajoutée');
return redirect('/devis');
     
     
  }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $transaction_ventes = transaction_ventes::where('vente_id', $id)->get();
        
        $ventes = ventes::findOrFail($id);
        $clients = clients::all();
        $classes = Classes::all();
        $id_vente = $id;
        $products = products::all();
        $entreprises = entreprises::all();
        
        return view('devis.edit_devis', compact('id_vente', 'transaction_ventes','classes', 'products', 'ventes','clients','entreprises' ));
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function edit(devis $devis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
   
            DB::beginTransaction();
    
            $client_id = clients::where('nom',$request->nom)->first()->id; 
            //  echo $client_id;
    
             $ventes= ventes::findOrFail($request->id);
    
          
            // 1. delete transaction : 
            $transaction_ventes = transaction_ventes::where('vente_id',$ventes->id)->get();
            foreach($transaction_ventes as $ts)
            {
             $ts->delete();
    
         }
        
        
         // 3.insert into transaction : 
         for( $i=2; $i<=100 ; $i++ )
         { 
             // designation
             
             $produits =$request->input('product_'.$i);
             
             if($produits)
             {
                 echo  $produits;
    
                 $id_produit = $request->input('product_'.$i);
                 $transaction_ventes = new transaction_ventes();
                 $transaction_ventes->vente_id =  $ventes->id;//!!!
                 $transaction_ventes->product_id =  $id_produit;
                 $transaction_ventes->prix_vente = $request->input('prix_vente_'.$i);
                 $transaction_ventes->quantite = $request->input('quantite_'.$i);
                 $transaction_ventes->save();
         
                  
                // $products = products::findOrFail($id_produit);
         
             
                // $products->update([
                //       'prix_vente'=> $request->input('prix_vente_'.$i),
                //       'quantite' => $products->quantite  - $request->input('quantite_'.$i),   
                //    ]);
              
              
    
     
            
             }
         
          
         
         }
    
     // 3.update ventes
     $ventes->update([
     'date'=>$request->date,
     'total_ht'=> $request->total_ht,
     'total_ttc' => $request->total_ttc,
     'client_id' =>$client_id  ,
     ]);
     
    //  $factures = factures::where('vente_id',$ventes->id)->first(); 
     
    //  $factures->update([
    //      'date_echeance'=> $request->dateech,
    //      'total_facture' => $ventes->total_ttc,
    //      'entreprise_id' => $request->entreprise_id,
    //     ]);
    
         DB::commit();
    
         session()->flash('edit', 'Le devis a bien été modifier');
            return redirect('/devis');
     
    }
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\devis  $devis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        $ventes= ventes::findOrFail($request->id1);

        $transaction_ventes = transaction_ventes::where('vente_id',$ventes->id)->get();
        
        foreach($transaction_ventes as $ts)
         {
            
          
       
            
          $ts->delete();

         }

        $ventes->delete();

        DB::commit();

        session()->flash('delete', 'le devis a bien été supprimer');
        return redirect('/devis');

    }

    public function afficher($id)
    {
        $entreprise = entreprises::get()->first();
        $vente = ventes::where('id', $id)->first();
        $transactions = transaction_ventes::where('vente_id', $id)->get();
        return view('devis/show',compact('vente','transactions','entreprise'));
      

    }

   public function print($id)
   {
    $entreprise = entreprises::get()->first();
    $vente = ventes::where('id', $id)->first();
    $transactions = transaction_ventes::where('vente_id', $id)->get();
    return view('devis/print',compact('vente','transactions','entreprise'));
  
   }

   public function signer($id)
   {
 
    DB::beginTransaction();

    $entreprise = entreprises::get()->first();
    $ventes = ventes::findOrFail($id);
    $transaction_ventes = transaction_ventes::where('vente_id',$ventes->id)->get();
    
     $ventes->devis=0;
     $ventes->save();

   foreach($transaction_ventes as $ts)
   {

    $newQuantity = $ts->product->quantite - $ts->quantite;

    // Vérifier si la nouvelle quantité est négative
    if ($newQuantity < 0) {
        // Annuler la transaction
        DB::rollback();

        // Mettre un message flash dans la session
        session()->flash('delete', 'La quantité du produit "' . $ts->product->reference . '" est invalide.');

        // Rediriger vers une page spécifique, par exemple la page précédente
        return redirect()->back();
    }


          $ts->product->update([
       'prix_vente'=> $ts->prix_vente,
       'quantite' => $ts->product->quantite - $ts->quantite,   
            ]);
    }


   $factures = new factures();
  
   $prefix = 'FAC-';
 
   $characters = '123456789';
  
   $randomString = '';
do{
   for ($i = 0; $i < 6; $i++) {
       
      $index = rand(0, strlen($characters) - 1);

       $randomString .= $characters[$index];
   }

   $prefix .= $randomString; 
  }while (factures::where('numero', $prefix)->exists());


  $factures->numero = $prefix;
  $factures->date_emission = $ventes->created_at ;      
  $factures->total_facture = $ventes->total_ttc;
  $factures->status = 0;
  $factures->vente_id = $ventes->id;
  $factures->entreprise_id = $entreprise->id;
  $factures->save();    
    
  DB::commit();
  session()->flash('edit', 'le devis a bien été signer');
  return redirect('/devis');
   }

  
   public function envoyer($id)
   {
       // Récupérer la facture avec ses relations
       $ventes = ventes::findOrFail($id);
    
       $user = clients::where('id',$ventes->client->id)->first();
       Notification::send($user, new devis($id,0));
       session()->flash('Add', 'le devis a bien été envoyer au client'.$user->nom.' '.$user->prenom);

       return redirect('/devis');
       
   
   }

}
