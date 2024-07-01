<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\factures;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:accueil', ['only' => ['index']]);
     
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $facts1 = factures::where('status',1)->get();
        $facts2 = factures::where('status',2)->get();
        $facts0 = factures::where('status',0)->get();
        $user0 = User::where('status','active')->get();
        $user1 = User::where('status','nonactive')->get();

   if(!(\App\Models\factures::count()))
        {
    $taux0=0;
    $taux1=0;
    $taux2=0;
    $tauxuser0=0;
    $tauxuser1=0;
      
     }else  
        {
        $taux0 = round((\App\Models\factures::where('status',0)->count())*100/ (\App\Models\factures::count()));
        $taux1 = round((\App\Models\factures::where('status',1)->count())*100/ (\App\Models\factures::count()));
        $taux2 = round((\App\Models\factures::where('status',2)->count())*100/ (\App\Models\factures::count()));
        $tauxuser0 = round((\App\Models\User::where('status','active')->count())*100/ (\App\Models\User::count()));
        $tauxuser1 = round((\App\Models\User::where('status','nonactive')->count())*100/ (\App\Models\User::count()));
        }


    // ExampleController.php

    $chartjs = app()->chartjs
    ->name('barChartTest')
    ->type('bar')
    ->size(['width' => 550, 'height' => 300])
    ->labels(['Facture non remis', 'Facture remis','Facture remis partiellement '])
    ->datasets([
        
        [   
            "label" => "Facture non remis en %",
            'backgroundColor' => ['#ec5858'],
            'data' => [$taux0], 
             
        ],
        [
            "label" => "Facture remis en %",
            'backgroundColor' => ['#81b214'],
            'data' => [$taux1]
        ],
        [
            "label" => "Facture remis partiellement en %",
            'backgroundColor' => ['#ff9642'],
            'data' => [$taux2]
        ],
    ])->options([]);
    
$chartjs1 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Utilisateurs actives en %', 'Utilisateurs non actives en %'])
        ->datasets([
            [
                'backgroundColor' => ['#81b214', '#green'],
                'hoverBackgroundColor' => ['#81b214', '#green'],
                'data' => [$tauxuser0, $tauxuser1]
            ]
        ])
        ->options([]);


        $total_remis = 0.0 ;
        $total_remis_part = 0.0 ;
        $total_non_remis = 0.0 ;
        
        foreach($facts1 as $f)
        {
        $total_remis = $total_remis + $f->vente->total_ttc; 
        }
        
        foreach($facts2 as $f)
        {
        $total_remis_part = $total_remis_part + $f->vente->total_ttc; 
        }


        foreach($facts0 as $f)
        {
        $total_remis = $total_non_remis + $f->vente->total_ttc; 
        }

        $factures = factures::take(5)->get();

         return view('home',compact('total_remis','total_remis_part','total_non_remis','chartjs','chartjs1','factures'));
  

    }
}
