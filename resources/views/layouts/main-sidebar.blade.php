<!-- j -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
		    </div>
		<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.png')}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0"> {{Auth::user()->name}} </h4>
							<span class="mb-0 text-muted"> {{Auth::user()->email}} </span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">Programme</li>
				@can('accueil')
					<li class="slide">
						<a class="side-menu__item" href="{{ url('/' . $page='home') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">Accueil</span></a>
					</li>
					@endcan
					<!-- factures -->

					<li class="side-item side-item-category">Factures</li>
					 
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg><span class="side-menu__label">Factures</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
					@can('facture')
					<li><a class="slide-item" href="{{ url('/' . $page='factures') }}"> Tous les factures</a></li>
					@endcan
					@can('archivage_facture')
						<li><a class="slide-item" href="{{ url('/' . $page='audit_factures') }}"> Historique des factures</a></li>
					@endcan	

						 </ul>
					</li>
 
					 <!-- rapports -->
                    @can('devis')
					
					<li class="side-item side-item-category">Devis</li>
					<li class="slide">
					 <a class="side-menu__item" href="{{ url('/' . $page='devis') }}">
						<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
						<span class="side-menu__label">Devis</span>
					</a></li>
 					
					@endcan 
				<!-- users -->
	 
					<li class="side-item side-item-category">Utilisateurs</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
								<path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
							  </svg>						
							  	<span class="side-menu__label">Utilisateurs</span><i class="angle fe fe-chevron-down"></i></a>
						
						<ul class="slide-menu">
							@can('user')
							<li><a class="slide-item" href="{{ url('/' . $page='users') }}">liste des Utilisateurs</a></li>
							@endcan
							@can('role')
							<li><a class="slide-item" href="{{ url('/' . $page='roles') }}">Roles des Utilisateurs</a></li>	
 					        @endcan
						</ul>
			 <!-- Stock -->

					<li class="side-item side-item-category">Stock</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
								<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
							  </svg>							
							<span class="side-menu__label">  Stock</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
 						@can('categorie')
						 <li><a class="slide-item" href="{{ url('/' . $page='classes') }}">Catégorie</a></li>
						@endcan
						@can('produit')
							<li><a class="slide-item" href="{{ url('/' . $page='products') }}">produits</a></li>
						@endcan
						@can('achat')
							<li><a class="slide-item" href="{{ url('/' . $page='achats') }}">Achats</a></li>
						@endcan
						@can('vente')
							<li><a class="slide-item" href="{{ url('/' . $page='ventes') }}">ventes</a></li>
						@endcan
						</ul>
					</li>


				 <!-- client -->
                  @can('client')
					  
				 <li class="side-item side-item-category">Clients</li>
					 <li class="slide">
					<a class="side-menu__item" href="{{ url('/' . $page='clients') }}">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
							<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
							<path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
						  </svg>
 					<span class="side-menu__label">Clients</span></a>
				</li>
				 @endcan

				<!-- entreprise -->

                 @can('entreprise')
				<li class="side-item side-item-category">Entreprise</li>
				<li class="slide">
					<a class="side-menu__item" href="{{ url('/' . $page='entreprises') }}">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
							<path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
						  </svg>	
 					<span class="side-menu__label">Entreprise</span></a>
				</li>		 	 
				@endcan

				  <!-- fournisseurs -->
                 @can('fournisseur')
				 <li class="side-item side-item-category">Fournisseurs</li>
				 <li class="slide">
					<a class="side-menu__item" href="{{ url('/' . $page='fournisseurs') }}">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
							<path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
						  </svg>	
 					<span class="side-menu__label">Fournisseur</span></a>
				</li>	
				 @endcan
				 
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
