<?php

namespace App\Http\Controllers;

use App\Models\achats;
use App\Models\transaction_achats;
use App\Models\hproducts;
use App\Models\products;
use App\Models\classes;
use App\Models\fournisseurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_achat', ['only' => ['store']]);
        $this->middleware('permission:modifier_achat', ['only' => ['update','show','update1']]);
        $this->middleware('permission:supprimer_achat', ['only' => ['destroy']]);
        $this->middleware('permission:achat', ['only' => ['index']]);

    }
    
    public function index()
    {
       $achats = achats::all();
       $products = products::all();
       $classes = classes::all();
       $fournisseurs = fournisseurs::all();
       $transaction_achats = transaction_achats::all();
       return view('achats.achats',compact('transaction_achats','achats','products','classes','fournisseurs'));
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
            'fournisseur_id' => 'required'
       ], [
            'date.required' => 'Veuillez entrer la date',
            'fournisseur_id.required' => 'Veuillez entrer le fournisseur',
            'total_ht.required' => 'Le total HT n\'ont entrés' ,
            'total_ttc.required' => 'Le total TTC n\'ont entrés' 
       ]); 
       
       DB::beginTransaction();

       $achats = new achats();
       $achats->date = $request->date;
       $achats->total_ht = $request->total_ht;
       $achats->total_ttc = $request->total_ttc;
       $achats->fournisseur_id = $request->fournisseur_id;
       $achats->save();
 
       $achat_id = $achats->id;

    for( $i=2; $i<=100 ; $i++ )
   {  
    // designation
    $id_produit =$request->input('product_'.$i);

    if($id_produit)
    {
 
        
        $transaction_achats = new transaction_achats();
        $transaction_achats->achat_id=  $achat_id;
        $transaction_achats->product_id=  $id_produit;
        $transaction_achats->prix_achat = $request->input('prix_achat_'.$i);
        $transaction_achats->quantite = $request->input('quantite_'.$i);
        $transaction_achats->save();



         
     $products = products::findOrFail($id_produit);
    //  $hproducts = hproducts::findOrFail($id_produit);

     
    // $hproducts->update([
    //     'prix_achat'=> $products->prix_achat,
    //     'quantite' => $products->quantite,   
    //  ]);

    $products->update([
        'prix_achat'=> $request->input('prix_achat_'.$i),
        'quantite' => $products->quantite + $request->input('quantite_'.$i),   
     ]);

  
   
    }

 

}

DB::commit();

session()->flash('Add', 'L\'achat a bien été ajouté');
return redirect('/achats');
 


  }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\achats  $achats
     * @return \Illuminate\Http\Response
     */
    public function show(achats $achats,$id)
    {
      
        $transaction_achats = transaction_achats::where('achat_id', $id)->get();
        
        $achats = achats::findOrFail($id);
        $fournisseurs = fournisseurs::all();
        $classes = Classes::all();
        $id_achat = $id;
        $products = products::all();
       return view('edit_achats.edit_achats', compact('id_achat', 'transaction_achats','classes', 'products', 'achats','fournisseurs' ));
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\achats  $achats
     * @return \Illuminate\Http\Response
     */
    public function edit(achats $achats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\achats  $achats
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, achats $achats)
     {
         
   
         DB::beginTransaction();
 
         $fournisseur_id = fournisseurs::where('nom',$request->nom)->first()->id; 
  
         $achats= achats::findOrFail($request->id);
 
       
        // 1. delete transaction : 
      $transaction_achats = transaction_achats::where('achat_id',$achats->id)->get();
    
      foreach($transaction_achats as $ts)
      {
       
          $products = products::findOrFail($ts->product_id);
       
          $products->update([
             'quantite' => $products->quantite - $ts->quantite ,   
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
              $transaction_achats = new transaction_achats();
              $transaction_achats->achat_id=  $achats->id;//!!!
              $transaction_achats->product_id=  $id_produit;
              $transaction_achats->prix_achat = $request->input('prix_achat_'.$i);
              $transaction_achats->quantite = $request->input('quantite_'.$i);
              $transaction_achats->save();
      
               
             $products = products::findOrFail($id_produit);
      
          
             $products->update([
                   'prix_achat'=> $request->input('prix_achat_'.$i),
                   'quantite' => $products->quantite  + $request->input('quantite_'.$i),   
                ]);
           
           
 
  
         
          }
      
       
      
      }
 
  // 3.update achats
  $achats->update([
  'date'=>$request->date,
  'prix_ht'=> $request->prix_ht,
  'prix_ttc' => $request->prix_ttc,
  'fournisseur_id' =>$fournisseur_id  ,
  ]);
 
 
      DB::commit();
 
      session()->flash('edit', 'l achat a bien été modifier');
         return redirect('/achats');
  
     }


     //   ----------------------------------------------------

      public function update1(Request $request, achats $achats)
      {
         
        $fournisseur_id = fournisseurs::where('nom', $request->nom)->first()->id;
        $product_id = products::where('reference', $request->reference)->first()->id;
        $achats= achats::findOrFail($request->id);
        $achats->update([
        'date'=>$request->date,
        'prix_achat'=> $request->prix_achat,
        'prix_ttc' => $request->prix_ttc,
        'quantite' => $request->quantite1,
        'product_id' => $product_id  ,
        'fournisseur_id' =>$fournisseur_id  ,  
        ]);


        $products = products::findOrFail($product_id);
        $products->update([
        'prix_achat'=> $request->prix_achat,
        'quantite'  => $products->quantite - $request->quantite + $request->quantite1,
         ]);
        session()->flash('edit', 'achat bien modifié');
        return redirect('/achats');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\achats  $achats
     * @return \Illuminate\Http\Response
     */
    public function destroy(achats $achats, Request $request)
    { 
       
        DB::beginTransaction();

        $achats= achats::findOrFail($request->id1);

        $transaction_achats = transaction_achats::where('achat_id',$achats->id)->get();
        
        foreach($transaction_achats as $ts)
        {
           
        
        $products = products::findOrFail($ts->product_id);

        if($products->quantite - $ts->quantite < 0)
            {
                session()->flash('delete', ' Attention la suppression ne peut pas s\'effectuer car ils vous reste au stock que '. $products->quantite. ' produits de  "'.$products->designation.'"');
                return redirect('/achats'); 
            }

        }


        foreach($transaction_achats as $ts)
         {
            
            $products = products::findOrFail($ts->product_id);
    
                     
          $products->update([
                 'quantite' => $products->quantite + $ts->quantite,   
                            ]);
       
            
          $ts->delete();

         }

     $achats->delete();

     DB::commit();

     session()->flash('delete', 'l achat a bien été supprimer');
     return redirect('/achats');


    }

    public function getProducts($id)
    {
        $products = DB::table("products")->where("section_id",$id)->pluck("designation","id");
        return json_encode($products);
    }

    public function getQuantites($id)
    {
        $products = DB::table("products")->where("id",$id)->pluck("quantite","id");
        return json_encode($products);
    }


    public function getQuantites1($id, $quantite)
    {
        $products = products::findOrFail($id);

        $NVquantite = $quantite - $products->quantite;
    
        if($NVquantite<0)
        $NVquantite = 0;

        $updatedProduct = DB::table("products")->where("id", $id)->pluck('quantite', 'id');
        $updatedProduct[$id] = $NVquantite;
    
        return response()->json($updatedProduct);
    
    }



 public function   getNotif()
 {
    return view('/notification');

 }
}
