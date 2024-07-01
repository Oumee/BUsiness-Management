<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\factures;
use App\Models\clients;
use App\Models\transaction_ventes;
use App\Notifications\facture;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Exports\FacturesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
 

class FacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        // 'archivage_facture',
        //    'archivage_facture_recycler',
        //    'archivage_facture_supprimer',


         $this->middleware('auth');
         $this->middleware('permission:exporter_facture', ['only' => ['export']]);
         $this->middleware('permission:recherche_facture', ['only' => ['showshow']]);
         $this->middleware('permission:modifier_facture', ['only' => ['update']]);
         $this->middleware('permission:imprimer_facture', ['only' => ['print']]);
         $this->middleware('permission:afficher_facture', ['only' => ['show']]);
         $this->middleware('permission:supprimer_facture', ['only' => ['destroy']]);
         $this->middleware('permission:modifier_solde_facture', ['only' => ['update']]);
         $this->middleware('permission:archivage_facture_recycler', ['only' => ['recuperer']]);
         $this->middleware('permission:archivage_facture_supprimer', ['only' => ['forcedestroy']]);
         $this->middleware('permission:archivage_facture', ['only' => ['show']]);
 
     }
    
     
    public function index()
    {
        $factures= factures::all();
        return view('factures/factures',compact('factures'));
      


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
        //
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       
        // Récupérer uniquement les produits supprimés
        $factures0 = factures::onlyTrashed()->where('status', 0)->get();
        $factures2 = factures::onlyTrashed()->where('status', 2)->get();
        $factures1 = factures::onlyTrashed()->where('status', 1)->get();
        return view('audit_factures/audit_factures',compact('factures0','factures1','factures2'));
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function edit(factures $factures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $factures = factures::findOrFail($request->id);
          
        $total = $factures->total_facture- $request->soldeAjouter;
       if( $request->soldeAjouter < 0)
       {
        
        session()->flash('warning', 'Montant entré n\'est pas valable');
        return redirect('/factures'); 
       }
        if($total == 0)
        {
            $factures->update([
                'total_facture'=> $total,
                'status'=> 1,
            ]);
            
            // $user = clients::where('id',$factures->vente->client->id)->first();
            // Notification::send($user, new facture($factures->id,2));

            session()->flash('Add', ' la facture numero '.$factures->numero.' est remis');
            return redirect('/factures');      
        }

        if($total < 0)
        {   
            session()->flash('warning', 'Attention le montant n\'est pas valable');
            echo $total;
            return redirect('/factures');
        }

        if($total > 0)
        {
            $factures->update([
                'total_facture'=> $total,
                'status'=> 2,
            ]); 
 
            session()->flash('warning', ' la facture considérée comme remis partiellement, il reste '.$total.'DH');
            return redirect('/factures');

        }
    }

    public function recuperer(Request $request)
    {
        $facture = factures::withTrashed()->find($request->id);

        if ($facture && $facture->trashed()) {
            $facture->restore();
            
            session()->flash('Add', ' la facture numero '.$facture->numero.' est récupérée ');
        }
        return redirect('/factures');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\factures  $factures
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $factures = factures::findOrFail($request->id);
        $factures->delete();
        // Storage::disk('telechargement')->delete($request->numero.'/'.$request->nom);
        // Storage::disk('telechargement')->deleteDirectory($request->numero);
         session()->flash('delete','Facture a bien été supprimée');
        return back();
    }

    public function forcedestroy(Request $request)
    {
        DB::beginTransaction();

        try {
            echo 'hi hi oumama';
            echo $request->id;

            // Récupérer et forcer la suppression de la facture
            $factures = factures::withTrashed()->findOrFail($request->id);
            echo 'ji'.$factures;
            $factures->forceDelete();
            // Ajouter un message de session pour confirmer la suppression
            session()->flash('warning', 'Facture est supprimée définitivement');
        
            // Valider la transaction
            DB::commit();
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();
        
            // Ajouter un message de session pour signaler l'erreur
            session()->flash('warning', 'Une erreur s\'est produite lors de la suppression de la facture'.$e->getMessage());
        
            // Afficher l'erreur (optionnel)
            echo ' Erreur: ',  $e->getMessage(), "\n";
        }
        
        // Rediriger vers la page précédente
       return back();
        

    }


    public function OpenFile($numero , $nom)
    {
        $files = Storage::disk('telechargement')->getDriver()->getAdapter()->applyPathPrefix($numero.'/'.$nom);
        return response()->file($files);
    }

    
    public function GetFile($numero , $nom)
    {
        $files = Storage::disk('telechargement')->getDriver()->getAdapter()->applyPathPrefix($numero.'/'.$nom);
        return response()->download($files);
    }
    public function getSolde($id)
    {
        $factures = DB::table("factures")->where("id",$id)->pluck("total_facture","id");
        return json_encode($factures);
    }

 

    public function print($id)
    { 
        
        $factures = factures::where('id', $id)->first();
        $transactions = transaction_ventes::where('vente_id', $factures->vente->id)->get();
        return view('factures/print_facture',compact('factures','transactions'));
      


    }
    public function afficher($id)
    { 
        
        $factures = factures::where('id', $id)->first();
        $transactions = transaction_ventes::where('vente_id', $factures->vente->id)->get();
        return view('factures/show_facture',compact('factures','transactions'));
      


    }
     
    public function download($id)
    {
        DB::beginTransaction();
      
     
            // Récupérer la facture avec ses relations
            $factures = factures::findOrFail($id);
            $user = clients::where('id',$factures->vente->client->id)->first();
          
            Notification::send($user, new facture($id,0));
          
             
            $factures = factures::all();
            echo 'hi';
            session()->flash('Add','Facture a envoyé à '.$user->nom);
            return view('factures/factures',compact('factures'));
   
       DB::commit();   
}



    public function export() 
    {
     return Excel::download(new FacturesExport, 'rapportsFactures.xlsx');
    }
   
   
   
    public function showshow()
    {
         return view('rapports.index');    
    }


    public function getfacture(Request $request)
    {

          // Vérifiez si une ou plusieurs cases à cocher sont cochées
            $status = $request->input('status', []);

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
               

            // Initialisez les variables pour chaque statut
            $remis = in_array('remis', $status);
            $remispart = in_array('remis_partiellement', $status);
            $nonremis = in_array('non_remis', $status);
          
            

               if( $request->start_at =='' && $request->end_at =='')
                       {
                        if($remis && $remispart && $nonremis ) 
                         {
                            $factures = factures::all();                    
                          } 
                          else
                          {
 
                          if ($remis && $remispart){
                                $factures = factures::whereIn('status', [1, 2])
                                ->get();
                                                     } 
                                                     else
                                                     {
                                                        if ($remis && $nonremis ) {
                                                            $factures = factures::whereIn('status', [1, 0])
                                                            ->get();                                                         
                                                                                 }
                                                                                 else{
                                                                                 if ($remispart && $nonremis ) {
                                                                                    $factures = factures::whereIn('status', [0, 2])
                                                                                    ->get();                                                         
                                                                                                               }
                                                                                                               else
                                                                                                               {
                                                                                                                if ($nonremis ) 
                                                                                                                {
                                                                                                                    $factures = factures::where('status','=',0)
                                                                                                                    ->get();

                                                                                                                }else
                                                                                                                {
                                                                                                                        if ($remis ) 
                                                                                                                    {
                                                                                                                        $factures = factures::where('status','=',1)
                                                                                                                        ->get();

                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        if ($remispart ) {
                                                                                                                            $factures = factures::where('status','=',2 )
                                                                                                                            ->get();
        
                                                                                                                        }else
                                                                                                                        {
                                                                                                                             
                                                                                                                                $factures = factures::all(); 
                                                                                                                        }
                                                                                                                    }
                                                                                                                
                                                                                                                
                                                                                                                    
                                                                                                                        }
                                                                                                                 }

                                                     }

                                                    
                          
                        }
                       
                      }
                    }
                       else
                       {

                        $request->validate([
                            'start_at'=>'required',
                            'end_at' => 'required',
                        ],[
                            'start_at.required' => 'Entrer la date de debut',
                            'end_at.unique' => 'Entrer la date de fin',
                        ]); 
                        
                        if ($remis && $remispart && $nonremis ) {
                            $factures = factures::whereBetween('date_emission',[$start_at,$end_at])->get();                    
                         } 
                          else{
                            
                          if ($remis && $remispart) {
                      $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                      ->whereIn('status', [1, 2])
                      ->get();
                                                     } 
                                                     else
                                                     {
                                                        if ($remis && $nonremis ) {
                                                            $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                            ->whereIn('status', [1, 0])
                                                            ->get();                                                         
                                                                                 }
                                                                                 else{
                                                                                 if ($remispart && $nonremis ) {
                                                                                    $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                                                    ->whereIn('status', [0, 2])
                                                                                    ->get();                                                         
                                                                                                               }
                                                                                                               else
                                                                                                               {
                                                                                                                if ($nonremis ) 
                                                                                                                {
                                                                                                                    $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                                                                                    ->where('status','=',0)
                                                                                                                    ->get();

                                                                                                                }else
                                                                                                                {
                                                                                                                        if ($remis ) 
                                                                                                                    {
                                                                                                                        $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                                                                                        ->where('status','=',1)
                                                                                                                        ->get();

                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        if ($remispart ) {
                                                                                                                            $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                                                                                            ->where('status','=',2 )
                                                                                                                            ->get();
        
                                                                                                                        }else
                                                                                                                        {
                                                                                                                             
                                                                                                                                $factures = factures::whereBetween('date_emission',[$start_at,$end_at])
                                                                                                                                ->get(); 
                                                                                                                        }
                                                                                                                    }
                                                                                                                
                                                                                                                
                                                                                                                    
                                                                                                                        }
                                                                                                                 }

                                                     }

                                                    
                          
                        }
                       
                      }
                       }
    
    return view('factures.factures',compact('factures'));
            
    //     }
          
    
    
    
    // 
}

    public function marquervue()
    {
$userun = auth()->user()->unreadNotifications;
if($userun)
{
$userun->markAsRead();
return back();
}
    }
}
