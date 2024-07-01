@extends('layouts.master')

@section('css')

<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->

<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> 
 
 @endsection
 

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1"> Tableau de bord </h2>
						  <p class="mg-b-0"> Modèle de tableau de bord de suivi des factures </p>
						</div>
					</div>
					 
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')


				<!-- row -->
     <div class="row d-flex justify-content-center ">
@php
 
	$topVente = DB::table('ventes')
    ->select('client_id', DB::raw('COUNT(*) as total_ventes'))
    ->groupBy('client_id')
    ->orderBy('total_ventes', 'desc')
    ->first();

	if($topVente){
	$nom= DB::table('clients')
		->select('nom')
		->where('id',$topVente->client_id)
		->first();

	$prenom= DB::table('clients')
		->select('prenom')
		->where('id',$topVente->client_id)
		->first();
		 
	}

    $topAchat = DB::table('achats')
    ->select('fournisseur_id', DB::raw('COUNT(*) as total_ventes'))
    ->groupBy('fournisseur_id')
    ->orderBy('total_ventes', 'desc')
    ->first();

	if($topAchat){
	$four= DB::table('fournisseurs')
    ->select('nom')
    ->where('id',$topAchat->fournisseur_id)
    ->first();
	}

            @endphp
					<div class="card overflow-hidden sales-card bg-secondary-gradient">
						<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
							<div class="">
								<h6 class="mb-3 tx-12 text-white">TOP CLIENT</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<div>
										<h4 class="tx-20 font-weight-bold mb-1 text-white">
											@if ($topVente)
											{{  $nom->nom}} {{  $prenom->prenom}}
											@endif
										</h4>
										{{-- <p class="mb-0 tx-12 text-white op-7">{{ \App\Models\factures::count() }}</p> --}}
									</div>
									<span class="ml-auto my-auto">
										 
									</span>
								</div>
							</div>
						</div>
					</div>
 				<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
					<div class="card overflow-hidden sales-card bg-secondary-gradient">
						<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
							<div class="">
								<h6 class="mb-3 tx-12 text-white">TOP FOURNISSEUR</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<div>
										<h4 class="tx-20 font-weight-bold mb-1 text-white">
										@if ($topAchat)
										{{  $four->nom}}											
										@endif	
										   </h4>
 									</div>
									<span class="ml-auto my-auto">
									 
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				</div>


				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL FACTURES</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format(\App\Models\ventes::sum('total_ttc'),2) }} DH </h4>
											<p class="mb-0 tx-12 text-white op-7">{{ \App\Models\factures::count() }} factures</p>
										</div>
										<span class="ml-auto my-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>  
											<span class="text-white op-7"> 100% </span>
										</span>
									</div>
									
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					 
 					
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL FACTURES NON REMIS</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format(  $total_non_remis ) }} DH</h4>
											<p class="mb-0 tx-12 text-white op-7">{{ \App\Models\factures::where('status',0)->count() }} factures</p>
										</div>
										<span class="ml-auto my-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
												@if (\App\Models\factures::count())
												{{ round( (\App\Models\factures::where('status',0)->count())*100/ (\App\Models\factures::count()))  }}%
													
												@endif
											
											
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>

					<div   class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL FACTURES REMIS</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format(  $total_remis ) }} DH</h4>
											<p class="mb-0 tx-12 text-white op-7">{{\App\Models\factures::where('status',1)->count()}} fcatures</p>
										</div>
										<span class="ml-auto my-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											
											<span class="text-white op-7"> 
												@if (\App\Models\factures::count())
												{{ round((\App\Models\factures::where('status',1)->count())*100/ (\App\Models\factures::count()) ) }}%

												@endif
											 </span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>


					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">TOTAL FACTURES REMIS PARTIELLEMENT</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format($total_remis_part) }} DH</h4>
											<p class="mb-0 tx-12 text-white op-7"> {{ \App\Models\factures::where('status',2)->count() }} factures </p>
										</div>
										<span class="ml-auto my-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7"> 
												
												@if (\App\Models\factures::count())
												
												{{ round((\App\Models\factures::where('status',2)->count())*100/ (\App\Models\factures::count()))  }}%												 
												
												@endif
											
											</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					 
					

 				</div>
				<!-- row closed -->
<!-- row opened -->
<div class="row row-sm">
	<div class="col-md-12 col-lg-12 col-xl-7">
					<div class="card" >	
						<div class="card-body">				
								<div style="width:99%;">
									{!! $chartjs->render() !!}
								</div>	 
						</div>
					 </div>	
	</div>
	<div class="col-md-15 col-lg-15 col-xl-5">

		<div class="card" >
			<div class="card-body">
									
					<div >
						{!! $chartjs1->render() !!}
					</div>	 
			</div>
       </div>
	</div>
						
</div>
<!-- row closed -->
				

				<!-- row opened -->
				<div class="row row-sm">
					<div class="card" style="width: 55%">
						<div class="card-header pb-1">
							<h3 class="card-title mb-2">Les clients récents</h3>
							<p class="tx-12 mb-0 text-muted"></p>
						</div>
						<div class="card-body p-0 customers mt-1">
							<div class="list-group list-lg-group list-group-flush">
								@foreach ($factures as $item)
											
								<div class="list-group-item list-group-item-action" href="#">
									<div class="media mt-0">
                                        <img src="{{ asset($item->vente->client->image) }}" width="50" height="50" class="rounded-circle img-thumbnail">
										<div class="media-body">
											<div class="d-flex align-items-center">
												<div class="mt-0">
													<h5 class="mb-1 tx-15">{{ $item->vente->client->nom}} {{ $item->vente->client->prenom}}</h5>
													<p class="mb-0 tx-13 text-muted">
													@if ($item->status == 1)
														<span class="text-success">Payé</span>
													@elseif($item->status == 0)
														<span class="text-danger">non Payé</span>
													@else
														<span class="text-warning"> Payé partiellement </span>
													@endif
													</p>
												</div>
												 
												<span class="ml-auto my-auto">
													<a href="/show/{{$item->id}}" target="_blank"> N Facture : <strong>{{$item->numero}}</strong></a>
											            
												</span>
													 
												 
												 
											</div>
										</div>
									</div>
								</div>
								@endforeach
								 
							</div>
						</div>
					</div>
 
					<div class="col-xl-4 col-md-12 col-lg-6"  >
						<div class="card"  style="width: 140%" >
							<div class="card-header pb-1">
								<h3 class="card-title mb-2">Activités </h3>
 							</div>
							<div class="product-timeline card-body pt-2 mt-1">
								<ul class="timeline-1 mb-0">
									<li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Produit</span>  
										<p class="mb-0 text-muted tx-12">{{\App\Models\products::count()}} Produits</p>
									</li>
									<li class="mt-0"> <i class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Ventes</span> 
										<p class="mb-0 text-muted tx-12"> {{\App\Models\ventes::count()}} Ventes</p>
									</li>
									<li class="mt-0"> <i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Achats</span>  
										<p class="mb-0 text-muted tx-12"> {{\App\Models\achats::count()}} Achats</p>
									</li>
									<li class="mt-0"> <i class="si si-people bg-warning-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Clients</span>  
										<p class="mb-0 text-muted tx-12">{{\App\Models\clients::count()}} Clients</p>
									</li>																
									<li class="mt-0"> <i class="si si-eye bg-purple-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Fournisseurs</span>  
										<p class="mb-0 text-muted tx-12"> {{\App\Models\fournisseurs::count()}} Fournisseurs</p>
									</li>
									<li class="mt-0 mb-0"> <i class="icon-note icons icons bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Entreprises</span>  
										<p class="mb-0 text-muted tx-12"> {{\App\Models\entreprises::count()}} Entreprises</p>
									</li>
								</ul>
							</div>
						</div>
					</div>

					
				 
				</div>

				<!-- row close -->

				<!-- row opened -->
		 
			</div>
		</div>
		 
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
 
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
   

<script>
	var botmanWidget = {
		aboutText: 'start',
		introMessage: "Bonjour",
		placeholderText: "Type your message here...",
        chatServer: '/botman', // Ensure this URL matches your route
	};
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

@endsection