@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />

    @section('title')
    Factures
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Factures
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Historique des factures</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<style>
    /* Ajoutez ces styles dans votre fichier CSS principal */

    #tab4 {
        background-color: #ffdddd; /* Couleur de fond pour "Non remis" */
        color: #d9534f; /* Couleur du texte pour "Non remis" */
    }

    #tab5 {
        background-color: #fff0b3; /* Couleur de fond pour "Remis partiellement" */
        color: #f0ad4e; /* Couleur du texte pour "Remis partiellement" */
    }

    #tab6 {
        background-color: #d4edda; /* Couleur de fond pour "Remis" */
        color: #5cb85c; /* Couleur du texte pour "Remis" */
    }

    /* Ajoutez des styles supplémentaires pour le hover */
    .nav-link.non-remis:hover,
    .nav-link.remis-partiellement:hover,
    .nav-link.remis:hover {
        opacity: 0.8;
    }
    
</style>


@if(session()->has('Add'))
<script>
window.onload = function() 
{
notif({
msg: "{{ session()->get('Add') }}",
type: "success"
})
}
</script>
@endif

@if(session()->has('warning'))
<script>
window.onload = function() 
{
notif({
msg: "{{ session()->get('warning') }}" ,
type: "warning"
})
}
</script>
@endif
 
@if(session()->has('delete'))
<script>
window.onload = function() 
{
notif({
msg: "facture bien été supprimé",
type: "warning"
})
}
</script>
@endif
<!-- row -->


<div class="row">

 
    

 {{-- tabs --}}
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="text-wrap">
                <div class="example">
            <div class="main-content-label mg-b-5">
               Factures
            </div>
             
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">Non remis</a></li>
                                    <li><a href="#tab5" class="nav-link" data-toggle="tab">Remis partiellement</a></li>
                                    <li><a href="#tab6" class="nav-link" data-toggle="tab">Remis</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                 
                                <div class="tab-pane active" id="tab4">
                                {{-- TAB 4 --}}
                       
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            

                        </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Numero</th>
                                <th class="border-bcottom-0">Date d'émission</th>
                                <th class="border-bcottom-0">Date d'écheance</th>
                                <th class="border-bcottom-0">status</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($factures0 as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->numero }}</td>
                                    <td>{{ $x->date_emission }}</td>
                                    <td>{{ $x->date_echeance }}</td>
                                 

                            @if($x->status==0)
                            <td>
                            <span class="badge badge-pill badge-danger ">non remis</span>
                            </td>
                            @endif
                            @if($x->status==1)
                            <td>
                            <span class="badge badge-pill badge-success ">remis</span>
                            </td>
                            @endif
                            @if($x->status==2)
                            <td>
                            <span class="badge badge-pill badge-warning ">remis partiellement</span>
                            </td>
                            @endif
                                    <td>
                            @if($x->status!=1)

                            @endif
                                         
                            
                              @can('archivage_facture_recycler')                      
                                <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"                                             
                                        data-id="{{ $x->id }}"  
                                        data-numero="{{ $x->numero }}"  
                                        data-toggle="modal" href="#modaldemo10" title="récuperer">
                                        <i class="las la-recycle"></i>
                                </a>
                                @endcan
                                @can('archivage_facture_supprimer')
                                  <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                             data-id="{{ $x->id }}"  
                                             data-numero="{{ $x->numero }}"  
                                             data-toggle="modal" href="#modaldemo9" title="supprimer">
                                             <i class="las la-trash"></i>
                                  </a>
                                  @endcan
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                       
               </div>

                                <div class="tab-pane" id="tab5">
                                    <div class="col-xl-12">
                                        <div class="card mg-b-20">
                                            <div class="card-header pb-0">
                                                 
                                
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                                                        style="text-align: center">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">#</th>
                                                                <th class="border-bottom-0">Numero</th>
                                                                <th class="border-bcottom-0">Date d'émission</th>
                                                                <th class="border-bcottom-0">Date d'écheance</th>
                                                                <th class="border-bcottom-0">status</th>
                                                                <th class="border-bottom-0">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($factures2 as $x)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $x->numero }}</td>
                                                                    <td>{{ $x->date_emission }}</td>
                                                                    <td>{{ $x->date_echeance }}</td>
                                                                 
                                
                                                            @if($x->status==0)
                                                            <td>
                                                            <span class="badge badge-pill badge-danger ">non remis</span>
                                                            </td>
                                                            @endif
                                                            @if($x->status==1)
                                                            <td>
                                                            <span class="badge badge-pill badge-success ">remis</span>
                                                            </td>
                                                            @endif
                                                            @if($x->status==2)
                                                            <td>
                                                            <span class="badge badge-pill badge-warning ">remis partiellement</span>
                                                            </td>
                                                            @endif
                                                                    <td>
                                                            @if($x->status!=1)
                                
                                                            @endif
                                                                         
                                                            
                                                                        
                                                                       
                                                                        <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                                                           
                                                                        data-id="{{ $x->id }}"  
                                                                        data-numero="{{ $x->numero }}"  
                                                                           data-toggle="modal" href="#modaldemo10" title="récuperer facture">
                                                                           <i class="las la-recycle"></i>
                                                                        </a>
                                                             
                                
                                                                  <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                           
                                                                             data-id="{{ $x->id }}"  
                                                                             data-numero="{{ $x->numero }}"  
                                                                                data-toggle="modal" href="#modaldemo9" title="supprimer">
                                                                                <i class="las la-trash"></i>
                                                                 </a>
                                                                     </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                                               </div>
                                <div class="tab-pane" id="tab6">
                                    <div class="col-xl-12">
                                        <div class="card mg-b-20">
                                            <div class="card-header pb-0">
                                                 
                                
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                                                        style="text-align: center">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">#</th>
                                                                <th class="border-bottom-0">Numero</th>
                                                                <th class="border-bcottom-0">Date d'émission</th>
                                                                <th class="border-bcottom-0">Date d'écheance</th>
                                                                <th class="border-bcottom-0">status</th>
                                                                <th class="border-bottom-0">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($factures1 as $x)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $x->numero }}</td>
                                                                    <td>{{ $x->date_emission }}</td>
                                                                    <td>{{ $x->date_echeance }}</td>
                                                                 
                                
                                                            @if($x->status==0)
                                                            <td>
                                                            <span class="badge badge-pill badge-danger ">non remis</span>
                                                            </td>
                                                            @endif
                                                            @if($x->status==1)
                                                            <td>
                                                            <span class="badge badge-pill badge-success ">remis</span>
                                                            </td>
                                                            @endif
                                                            @if($x->status==2)
                                                            <td>
                                                            <span class="badge badge-pill badge-warning ">remis partiellement</span>
                                                            </td>
                                                            @endif
                                                                    <td>
                                                            @if($x->status!=1)
                                
                                                            @endif
                                                                         
                                                            
                                                                        <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                                                                                
                                                                        data-id="{{ $x->id }}"  
                                                                        data-numero="{{ $x->numero }}"  
                                                                        data-toggle="modal" href="#modaldemo10" title="récuperer facture">
                                                                        <i class="las la-recycle"></i>
                                                                </a>
                                                                                
                                                           
                                                             
                                
                                                                  <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                           
                                                                             data-id="{{ $x->id }}"  
                                                                             data-numero="{{ $x->numero }}"  
                                                                                data-toggle="modal" href="#modaldemo9" title="supprimer">
                                                                                <i class="las la-trash"></i>
                                                                 </a>
                                                                     </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
<!---Prism Pre code-->
<figure class="highlight mb-0" id="element2"><pre><code class="language-markup mb-0"><script type="prismsmix/javascript"><div class="panel panel-primary tabs-style-2">
 
</div></script></code></pre>
<div class="clipboard-icon" data-clipboard-target="#element2"><i class="las la-clipboard"></i></div>
</figure>
<!---Prism Pre code-->
            </div>
        </div>
    </div>
</div>
    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer une facture</h6>  <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="/factures/destroy" method="post">
                     {{ csrf_field() }}
                        <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer la facture numero : </p><br>

                        <input class="form-control" name="numero" id="numero" type="text" readonly>
                        <input class="form-control" name="id" id="id" type="hidden" >
                        </div>
                       
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                        </div>
                    </div>
                  </form>
        </div>
    </div>


 <!-- Recuperer -->
 <div class="modal" id="modaldemo10">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Récupérer la facture </h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="/factures/recuperer" method="post">
                 {{ csrf_field() }}
                    <div class="modal-body">
                    <p> Voulez-vous récupérer la facture numero : </p><br>
                    
                    <input class="form-control" name="numero" id="numero" type="text" readonly>
                    <input class="form-control" name="id" id="id" type="hidden" >
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </div>
        </div>
        </form>
    </div>
</div>

    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Add -->

 

<!-- Edit -->


<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


 
<script>

    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var date = button.data('date');
        var total_ht = button.data('total_ht');
        var total_ttc = button.data('total_ttc');
        var nom = button.data('nom');
 
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #total_ht').val(total_ht);
        modal.find('.modal-body #total_ttc').val(total_ttc);
        modal.find('.modal-body #nom').val(nom);

         
        
       
 
    });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var numero = button.data('numero')

         var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #numero').val(numero);
      })

</script>
 

<script>
    $('#modaldemo10').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var numero = button.data('numero')

         var modal = $(this)

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #numero').val(numero);
      })

</script>
 


<script>


function Produits(elem)
    {
        var x = elem;

        var SectionId = document.getElementById("selection_"+x).value;
         var flag=0;
        
        console.log('hoi ',SectionId)
        console.log('hoi ',elem)

        if (SectionId) {

                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            
                            console.log(data)

                            $('select[name="product_'+x+'"]').empty();
                            $('select[name="product_'+x+'"]').append('<option> -- Selectionner un produit  -- </option>');

                            $.each(data, function(key, value) {
                               
                                console.log('key : ',key)
                                console.log('value : ',value)
                                console.log('productCount ', productCount)
                       
                                for(var i=2 ; i<=productCount; i++)
                                        {
                                      
                                            if(!document.getElementById("product_"+i))
                                              continue;

                                             var valeur =  document.getElementById("product_"+i).value;
                                       
                                             console.log('valeur ',valeur); 

                                            if(key===valeur)
                                              {
                                                 flag=1;
                                              }
                                         }
                                        
                                        if(flag==0)
                                        {
                                            $('select[name="product_'+x+'"]').append('<option value="' + key + '">' + value + '</option>');
                                        }
                                     
                                     flag=0;
                        
                                         
                             });

                        
 
                        },
                    });
    
                } else {
                    console.log('AJAX load did not work');
                }    

    }
    

    
     
    
    </script>
<script>
    function toUpdate(id) {
        console.log(id);
        document.cookie = "id_achat=1";

        // Envoi de l'ID d achat au script PHP via AJAX
        // $.ajax({
        //     type: "POST",
        //     url: "ventes/show", // Chemin vers votre script PHP
        //     data: { 
        //         id_vente: id ,
        //         _token: '{{ csrf_token() }}' // Inclure le jeton CSRF
        //     },
        //     success: function(response) {
        //         console.log("ID de vente mis à jour avec succès : " + JSON.stringify(response));
        //     },
        //     error: function(xhr, status, error) {
        //         console.error("Erreur lors de la mise à jour de l'ID de vente : " + error);
        //     }
        // });
    }
</script>

<script>

$(document).ready(function() {
        $('select[name="Section1"]').on('change', function() {
            var SectionId = $(this).val();
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log('success')
                        $('select[name="reference"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="reference"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });
      });

</script>

<script>
  function myFunction() {
    var prix_net = 0; // Initialisez prix_net à 0 en dehors de la boucle
    console.log(productCount)
    for (var i = 2; i <= productCount; i++) {
         if(document.getElementById("prix_achat_" + i))
        {
        var prix_achat = parseFloat(document.getElementById("prix_achat_" + i).value);
        var quantite = parseFloat(document.getElementById("quantite_" + i).value);
        prix_net += prix_achat* quantite;
       
        }
    }

    var taux = parseFloat(document.getElementById("taux").value);

    if (isNaN(prix_achat) || prix_achat === 0) {
        alert('Entrez le prix d\'achat');
    } else if (isNaN(quantite) || quantite === 0) {
        alert('Entrez la quantité');
    } else {
        var prix_ttc = prix_net * (1 + taux / 100);
        var sum = prix_ttc.toFixed(2); // Assurez-vous que sum est déclarée
        document.getElementById("total_ttc").value = sum;
        document.getElementById("total_ht").value = prix_net.toFixed(2);
    }
}

</script>



<script>
    
    function myFunctionUpdate() {

        var prix_achat = parseFloat(document.getElementById("prix_achat1").value);
        var quantite = parseFloat(document.getElementById("quantite1").value);
        var taux = parseFloat(document.getElementById("taux1").value);

        var prix_net = prix_achat * quantite;


        if (typeof prix_achat === 'undefined' || !prix_achat) {

            alert('Entrer le prix d\'achat'');

        } else {
            if (typeof quantite === 'undefined' || !quantite) {

                alert('Entrer la quantité');

                } else {
            var prix_ttc = prix_net * (1 + taux / 100);

            sum = parseFloat(prix_ttc).toFixed(2);

            document.getElementById("prix_ttc1").value = sum;

        }

    }

}

</script>
  
<script>
    
    $(document).ready(function() {
        $('select[name="Section"]').on('change', function() {
            var SectionId = $(this).val();
            console.log(SectionId);
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log('success')
                        $('select[name="product"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });
      });

</script>
 
 
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>

function removeParentDiv(element)
       {
        element.parentNode.parentNode.remove();
       }
       <!--Internal  Notify js -->
</script>

 
@endsection
