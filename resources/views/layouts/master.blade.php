<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		@include('layouts.head')
		<style>
			body {
				display: flex;
				min-height: 100vh;
				margin: 0;
				direction: ltr;
				text-align: left;
				margin-left: 240px; /* Déplace le contenu vers la droite de 20px */
			
			}
			.main-content {
				/* background-color: #;  */
				padding: 20px; /* Ajoute un espace à l'intérieur pour ne pas coller au bord */
		margin-left: 20px; /* Marge à gauche */
		margin-right: 20px; /* Marge à droite */		
			}
			.main-header {
			 padding: 20px;  /* Ajoute un espace à l'intérieur pour ne pas coller au bord */
			margin-left: 20px; /* Marge à gauche */
			padding-top: 60px;
			padding-bottom: 4px;
  		
		}
			  .jumps-prevent {
				padding-top: 100px;
			  }
			 
			</style>
	</head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
	     <img src="{{URL::asset('assets/img/YD.jpeg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		   @include('layouts.main-sidebar')  
		<!-- main-content -->
		<div class="main-content app-content">
				@include('layouts.main-header')			
				<!-- container -->
				<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				@include('layouts.sidebar')
				@include('layouts.models')
            	@include('layouts.footer')
				@include('layouts.footer-scripts')	
	</body>
</html>

<script>

</script>
