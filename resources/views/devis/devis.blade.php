@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@section('title')
    Devis
@stop
 
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Devis</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                listes des devis</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<!-- row -->
<div class="row">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    @can('ajouter_devis')
                    <a class="btn btn-primary" data-effect="effect-scale"
                    data-toggle="modal" href="#modaldemo8"> Ajouter un devis </a>
                    @endcan
                    
                 </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bcottom-0">Total HT</th>
                                <th class="border-bcottom-0">Total TTC</th>
                                <th class="border-bcottom-0">client</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  $i = 0; ?>
                            @foreach ($ventes as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->date }}</td>
                                    <td>{{ $x->total_ht }}</td>
                                    <td>{{ $x->total_ttc }}</td>
                                    <td>{{ $x->client->nom }}</td>
                                   
                                    <td>
                                        <div class="container mt-5">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="las la-file-invoice"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @can('modifier_devis')
                                                    <a class="dropdown-item" href="/devis/show/{{$x->id}}" title="modifier">
                                                        <i class="las la-pen"></i> Modifier
                                                    </a>
                                                    @endcan
                                                    <a class="dropdown-item" href="envoyer/{{$x->id}}" title="ENVOYER">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                                                            <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                                                            <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                                                          </svg> Envoyer devis par email </a>

                                                    <a class="dropdown-item" href="{{ url('print_devis') }}/{{ $x->id }}" title="Imprimer">
                                                        <i class="las la-print"></i> Imprimer
                                                    </a>
                                                    <a class="dropdown-item" href="{{ url('show_devis') }}/{{ $x->id }}" title="Afficher">
                                                        <i class="las la-eye"></i> Afficher </a>
                                                    @can('supprimer_devis')
                                                    <a class="dropdown-item" data-effect="effect-scale"  data-id1="{{ $i }}"  
                                                    data-id2="{{ $x->id }}"   data-numero="" data-toggle="modal" href="#modaldemo9" title="supprimer">
                                                        <i class="las la-trash"></i> Supprimer </a>
                                                    @endcan
 
                                                       <a  class="dropdown-item" href="{{ url('signer') }}/{{ $x->id }}" title="Signer">
                                                            <i class="las la-pen"></i> Signer  
                                                       </a>

                                                </div>
                                            </div>
                                        </div>
                                      
                                        
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- add -->

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> Ajouter un devis </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('devis.store') }}" method="post" >
                        @csrf


                        <div class="form-group">
                           <label for="date"> Sélectionner une date </label>
                           <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                         <label for="inputName" class="control-label"> Sélectionner une entreprise </label>
                          <select name="entreprise_id" id="entreprise_id" class="form-control" onchange="" required>
                            @foreach($entreprises as $e)
                       
                            <option value="{{ $e->id }}">{{ $e->nom }}</option>
                           
                            @endforeach
                             </select>
                        </div>

                     <table class="table table-bordered" id="produits">
                        <tr>
                            <th> Catégorie </th>
                            <th> Produit </th>
                            <th> Prix de vente </th>
                            <th> Quantité </th>
                            <th> Opération </th>
                        </tr>
                        
                     </table>
                     <button type="button" class="btn btn-secondary" onclick="addProduct()" > Ajouter un produit 🛒 </button>
                      
                    
                    
                    <div class="form-group">
                        <label for="total_ht">Total HT</label>
                        <input type="text" class="form-control" id="total_ht" name="total_ht" readonly>
                    </div>



                    <div class="form-group">
                            <label for="inputName" class="control-label">  Taux de taxe  </label>
                            <select name="taux" id="taux" class="form-control" onchange="myFunction()" required>
                                <!--placeholder-->
                                <option value=" 2%">2%</option>
                                <option value=" 5%">5%</option>
                             </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="total_ttc">Total TTC</label>
                            <input type="text" class="form-control" id="total_ttc" name="total_ttc" readonly>
                        </div>
                       
                       
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Client</label>

                        <select name="client_id" id="client_id" class="form-control" required>
                        <option value="" selected disabled> -- Selectionner un Client  --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                        @endforeach
                        </select>

                        <div class="form-group">
                            <label for="date"> Sélectionner une date d'échéance </label>
                            <input type="date" class="form-control" id="dateech" name="dateech" value="{{ date('Y-m-d') }}">
                         </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Confirmer</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                        </div>


                    </form>
                    
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


    </div>
 

          <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer un devis</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="devis/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer le devis numero : </p> <br>
                        <input class="form-control" name="id" id="id" type="text" readonly>
                        <input class="form-control" name="id1" id="id1" type="hidden">
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

<script>
    let productCount = 1;

    function addProduct() {
        productCount++;
        const productDiv = document.createElement('tr');
        productDiv.className = 'table table-bordered';
        // productDiv.style.border = '1px solid  '; // Définit une bordure de 1 pixel solide en noir
        console.log('yes');
        productDiv.innerHTML = `
            <td>
                <select name="Section_${productCount}" class="form-control" id="selection_${productCount}" onchange="Produits(${productCount})" required>
                    <option value="" selected disabled> -- Selectionner une catégorie  -- </option>
                    @foreach($classes as $classe)  
                    <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_${productCount}" id="product_${productCount}" class="form-control" onchange="Quantites(${productCount})" required>
                 </select>
            </td>

            <td>
                <input type="text" class="form-control" id="prix_vente_${productCount}" name="prix_vente_${productCount}"  onchange="Quantites(${productCount})"  required >
            </td>
            <td>
                <input type="number" class="form-control" id="quantite_${productCount}" name="quantite_${productCount}"   onchange="myFunction()" required >
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeParentDiv(this);  myFunction()"   >🚮</button>
            </td>
        `;
         document.getElementById('produits').appendChild(productDiv);
    }
</script>

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




<script>

    let x = 1;
    function editProduct() {
        x++;
        const productDiv = document.createElement('tr');
        productDiv.className = '';
        // productDiv.style.border = '1px solid  '; // Définit une bordure de 1 pixel solide en noir
         productDiv.innerHTML = `
            <td>
                <select name="Section_${productCount}" class="form-control" id="selection_${productCount}" onchange="Produits(${productCount})" required>
                    <option value="" selected disabled> -- Selectionner une catégorie  -- </option>
                    @foreach($classes as $classe)  
                    <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>

                <select name="product_${productCount}" id="product_${productCount}" class="form-control">
                    <option value="" selected disabled> -- Selectionner une catégorie  -- </option>
             </select>
            </td>
            <td>
                <input type="text" class="form-control" id="prix_vente_${productCount}" name="prix_vente_${productCount}"   >
            </td>
            <td>
                <input type="number" class="form-control" id="quantite_${productCount}" name="quantite_${productCount}"   onchange="myFunction()">
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeParentDiv(this);  myFunction()" >🚮</button>
            </td>
        `;
        document.getElementById('produits-edit').appendChild(productDiv);
    }
</script>

<script>

    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var date = button.data('date');
        var total_ht = button.data('total_ht');
        var total_ttc = button.data('total_ttc');
        var nom = button.data('nom');
 
        @foreach ($ventes as $x)
        @foreach($transaction_ventes as $ts)
        @if($ts->vente_id == $x->id)

        var product_{{$ts->id}} = button.data('product_{{$ts->id}}');
        var prix_vente_{{$ts->id}} = button.data('prix_vente_{{$ts->id}}');
        var quantite_{{$ts->id}} = button.data('quantite_{{$ts->id}}');

        @endif
        @endforeach
        @endforeach
 

        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #total_ht').val(total_ht);
        modal.find('.modal-body #total_ttc').val(total_ttc);
        modal.find('.modal-body #nom').val(nom);

        @foreach ($ventes as $x)
        @foreach($transaction_ventes as $ts)
        @if($ts->vente_id == $x->id)
        
        modal.find('.modal-body #product_{{$ts->id}}').val(product_{{$ts->id}});
        modal.find('.modal-body #prix_vente_{{$ts->id}}').val(prix_vente_{{$ts->id}});
        modal.find('.modal-body #quantite_{{$ts->id}}').val(quantite_{{$ts->id}});

        @endif
        @endforeach
        @endforeach
        
       
 
    });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id1')
        var id1 = button.data('id2')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #id1').val(id1);
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
                            $('select[name="product_'+x+'"]').append('<option  disabled> -- Selectionner un produit  -- </option>');

                            $.each(data, function(key, value) {
                               
                                console.log(key)
                                console.log(value)
                                console.log('productCount ', productCount)
                       
                                for(var i=2 ; i<=productCount; i++)
                                        {
                                      
                                            if(!document.getElementById("product_"+i))
                                              continue;

                                             var valeur =  document.getElementById("product_"+i).value;
                                       
                                             console.log('valeur ',valeur) 
                                           
                                          
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
    

    
    function Quantites(elem)
    {
        var x = elem;

        var ProduitId = document.getElementById("product_"+x).value;
         
       
        console.log('hoi ',elem);

        if (ProduitId) {
                    $.ajax({
                        url: "{{ URL::to('produit') }}/" + ProduitId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                           
                            $.each(data, function(key, value) {
                            $('input[name="quantite_'+x+'"]').attr({
                                type: 'number',
                                min: 1,
                                max: value,
                                }).on('input', function() {
                                var newValue = $(this).val(); // Récupérer la nouvelle valeur de l'input
                                console.log("key ; value : " + key+" ; "+value);
                                // Autres actions à effectuer en fonction de la nouvelle valeur
                            });
                          // Vérifier si value est NULL
                                  if (value === null || value == 0 ) {
                                    var confirmation = confirm("Attention La quantite de ce produit est NULL 🛑🛑. Voulez-vous effectue un achat ?");
                                    if (confirmation) {
                                        // Si l'utilisateur clique sur "OK", ouvrez le lien
                                        window.open("http://oume:8000/achats");
                                    }
                                }
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
        document.cookie = "id_vente=1";

        // Envoi de l'ID de vente au script PHP via AJAX
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
         if(document.getElementById("prix_vente_" + i))
        {
        var prix_vente = parseFloat(document.getElementById("prix_vente_" + i).value);
        var quantite = parseFloat(document.getElementById("quantite_" + i).value);
        prix_net += prix_vente * quantite;
       
        }
    }

    var taux = parseFloat(document.getElementById("taux").value);

    if (isNaN(prix_vente) || prix_vente === 0) {
        alert('Entrez le prix de vente');
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

        var prix_vente = parseFloat(document.getElementById("prix_vente1").value);
        var quantite = parseFloat(document.getElementById("quantite1").value);
        var taux = parseFloat(document.getElementById("taux1").value);

        var prix_net = prix_vente * quantite;


        if (typeof prix_vente === 'undefined' || !prix_vente) {

            alert('Entrer le prix de vente');

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

</script>

 
@endsection
