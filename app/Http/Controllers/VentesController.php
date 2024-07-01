<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ventes;
use App\Models\User;
use App\Models\products;
use App\Notifications\facture;
use App\Notifications\AlertNotification;
use App\Models\classes;
use App\Models\transaction_ventes;
use App\Models\clients;
use App\Models\entreprises;
use App\Models\factures;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Notification;
 

class VentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_vente', ['only' => ['store']]);
        $this->middleware('permission:modifier_vente', ['only' => ['update','show']]);
        $this->middleware('permission:supprimer_vente', ['only' => ['destroy']]);
        $this->middleware('permission:vente', ['only' => ['index']]);

    }
    
    public function index()
    {
        $transaction_ventes = transaction_ventes::all();
        $ventes = ventes::where('devis',0)->get();
        $products = products::all();
        $classes = classes::all();
        $clients = clients::all();
        $entreprises = entreprises::all();
        return view('ventes.ventes',compact('ventes','products','classes','clients','transaction_ventes','entreprises'));
   
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
       $ventes->devis = 0;
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



         
     $products = products::findOrFail($id_produit);
    
   
  
    $products->update([
       'prix_vente'=> $request->input('prix_vente_'.$i),
       'quantite' => $products->quantite - $request->input('quantite_'.$i),   
    ]);


    }

 

      }
    // generation de facture 

// numero de facture 

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
if($request->date_echeance)
$factures->date_echeance = $request->dateech;      
$factures->total_facture = $ventes->total_ttc;
$factures->status = 0;
$factures->vente_id = $ventes->id;
$factures->entreprise_id = $request->entreprise_id;
 $factures->save();    
  
 $id_facture = $factures->id;
// envoie message à user


// envoie notification
$user = User::find(Auth::user()->id);
Notification::send($user, new AlertNotification($factures->id));

DB::commit();
session()->flash('Add', 'La vente a bien été ajoutée');
return redirect('/ventes');
     
     
  }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ventes  $ventes
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
        $factures = factures::where('vente_id',$ventes->id)->first(); 
        return view('edit_ventes.edit_ventes', compact('id_vente', 'transaction_ventes','classes', 'products', 'ventes','clients','entreprises','factures' ));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ventes  $ventes
     * @return \Illuminate\Http\Response
     */
    public function edit(ventes $ventes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ventes  $ventes
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, ventes $ventes)
    {
        
  
        DB::beginTransaction();

        $client_id = clients::where('nom',$request->nom)->first()->id; 
         echo $client_id;

         $ventes= ventes::findOrFail($request->id);

      
    // 1. delete transaction : 
     $transaction_ventes = transaction_ventes::where('vente_id',$ventes->id)->get();
     foreach($transaction_ventes as $ts)
     {
         $products = products::findOrFail($ts->product_id);
      
         $products->update([
            'quantite' => $products->quantite + $ts->quantite ,   
         ]);
         
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
     
            $products = products::findOrFail($id_produit);
     
         
            $products->update([
                  'prix_vente'=> $request->input('prix_vente_'.$i),
                  'quantite' => $products->quantite  - $request->input('quantite_'.$i),   
               ]);
          
          

 
        
         }
     
      
     
     }

 // 3.update ventes
 $ventes->update([
 'date'=>$request->date,
 'total_ht'=> $request->total_ht,
 'total_ttc' => $request->total_ttc,
 'client_id' =>$client_id  ,
 ]);
 
 $factures = factures::where('vente_id',$ventes->id)->first(); 
 
 $factures->update([
     'date_echeance'=> $request->dateech,
     'total_facture' => $ventes->total_ttc,
     'entreprise_id' => $request->entreprise_id,
   
    ]);
    DB::commit();


     session()->flash('edit', 'la vente a bien été modifier');
      return redirect('/ventes');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ventes  $ventes
     * @return \Illuminate\Http\Response
     */
    public function destroy(ventes $ventes,Request $request)
    {
       
        DB::beginTransaction();

        $ventes= ventes::findOrFail($request->id1);

        $transaction_ventes = transaction_ventes::where('vente_id',$ventes->id)->get();
        
        foreach($transaction_ventes as $ts)
         {
            
            $products = products::findOrFail($ts->product_id);
    
                     
          $products->update([
                 'quantite' => $products->quantite + $ts->quantite,   
                            ]);
       
            
          $ts->delete();

         }

     $ventes->delete();

     DB::commit();
    
     session()->flash('delete', 'la vente a bien été supprimer');
     echo 'hi';
       return redirect('/ventes');


    }


    public function getQuantites($id,$quantite)
    {
    
    $products = products::findOrFail($id);
    $NVquantite = $products->quantite + $quantite;

    $updatedProduct = DB::table("products")->where("id", $id)->pluck('quantite', 'id');
    $updatedProduct[$id] = $NVquantite;

    return response()->json($updatedProduct);

    }


    public function getQuantitesInsert($id)
    {
 
 
       
       $updatedProduct = DB::table("products")->where("id", $id)->pluck('quantite', 'id');
      

    return response()->json($updatedProduct);


    
    }
}
