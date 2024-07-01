<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\classes;
use App\Models\hproducts;

use Illuminate\Http\Request;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ajouter_produit', ['only' => ['store']]);
        $this->middleware('permission:modifier_produit', ['only' => ['update']]);
        $this->middleware('permission:supprimer_produit', ['only' => ['destroy']]);
        $this->middleware('permission:produit', ['only' => ['index']]);
    
    }
    
    public function index()
    {
        $classes= classes::all();
        $products= products::all();
        return view('products/products',compact('classes','products'));
        
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
             'reference'=>'required|unique:products|max:255',
            'designation' => 'required',
             'section_id' => 'required',
             ], [
            'reference.required' => 'Veuillez entrer la référence',
           'reference.unique' => 'La référence existe déjà',
            'designation.required' => 'Veuillez entrer la désignation',
             'section_id.required' => 'Veuillez entrer la catégorie',
         ]); 
      
   

    if (!$request->hasFile('image'))  

    {

        $product = new products(); // Use singular 'Product' for the model name
        $product->reference = $request->reference;
        $product->designation = $request->designation;
        $product->codebare = $request->codebare;
        $product->section_id = $request->section_id;
        $product->quantite = 0;
         $product->save();

    }else{
    $requestData = $request->all();

     $fileName = time().$request->file('image')->getClientOriginalName();
    $path = $request->file('image')->storeAs('images',$fileName,'public');
    $requestData['image'] = '/storage/' . $path;

 
    $product = new products(); // Use singular 'Product' for the model name
    $product->reference = $request->reference;
    $product->designation = $request->designation;
    $product->codebare = $request->codebare;
    $product->section_id = $request->section_id;
    $product->quantite = 0;
    $product->image =  $requestData['image'];// Fixed typo 'omage' to 'image'
    $product->save();

    } 


        session()->flash('Add','le produit a bien été ajouté');
        return  redirect('/products');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products,Request $request)
    {   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, products $products)
    {
        $id = classes::where('section_name', $request->section_name)->first()->id;
        $products= products::findOrFail($request->id);
        

        
    $requestData = $request->all();

    if ($request->hasFile('image'))  
    {

    $fileName = time().$request->file('image')->getClientOriginalName();
    $path = $request->file('image')->storeAs('images',$fileName,'public');
    $requestData['image'] = '/storage/' . $path;
    echo  $requestData['image'];
    $products->update([
        'reference'=>$request->reference,
        'designation' =>$request->designation,
        'codebare' => $request->code_bare,
        'prix_achat'=> $request->prix_achat,
        'prix_vente' => $request->prix_vente,
        'quantite' => $request->quantite,
        'section_id' => $id,
        'image' => $requestData['image'],
        
        ]);
    
    }else{
        $products->update([
        'reference'=>$request->reference,
        'designation' =>$request->designation,
        'codebare' => $request->code_bare,
        'prix_achat'=> $request->prix_achat,
        'prix_vente' => $request->prix_vente,
        'quantite' => $request->quantite,
        'section_id' => $id
        
        ]);
    }

      

        session()->flash('edit', 'produit bien modifié');
        return redirect('/products'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(products $products,Request $request)
    {
        $Products = products::findOrFail($request->id);
        $Products->delete();
        session()->flash('delete', 'Produit bien été supprimé ');
        return back();
    }
    public function import() 
    {
        Excel::import(new ProductsImport, request()->file('excel'));
        return redirect('/products')->with('success', 'All good!');
    }
}
