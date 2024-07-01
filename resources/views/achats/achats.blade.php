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
    Achats
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Achats
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                listes des achats</span>
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
                @can('ajouter_achat')

                            <a class="btn btn-primary" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8"> Ajouter un achat</a>
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
                                <th class="border-bcottom-0">Fournisseur</th>
                                 <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($achats as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->date }}</td>
                                    <td>{{ $x->total_ht }}</td>
                                    <td>{{ $x->total_ttc }}</td>
                                    <td>{{ $x->fournisseur->nom }}</td>
                                    
                                    <td>
                                    
                                        @can('modifier_achat')
                                        <a  
                                            
                                             href="achats/show/{{$x->id}}" 
                                             title="modifier">
                                             <i class="las la-pen"></i>
                                        </a>
                                         @endcan
                                        @can('supprimer_achat')
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id1="{{ $i }}"  
                                        data-id2="{{ $x->id }}"  
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

    <!-- add -->

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title"> Ajouter une achat </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('achats.store') }}" method="post"  >
                        @csrf
                        <div class="form-group">
                            <label for="date"> Sélectionner une date </label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>


                     <table class="table table-bordered" id="produits">
                        <tr>
                            <th>Catégorie</th>
                            <th>Produit</th>
                            <th>Prix de achat</th>
                            <th>Quantité</th>
                            <th>Opération</th>
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
                       
                       
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Fournisseur</label>

                        <select name="fournisseur_id" id="fournisseur_id" class="form-control" required>
                        <option value="" selected disabled> -- Selectionner un fournisseur  --</option>
                        @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                        @endforeach
                        </select>

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
    <!-- edit -->
     
 
      <!-- delete -->
      <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer un achat</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="achats/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                        <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer l'achat numero : </p><br>
                        
                        <input class="form-control" name="id" id="id" type="text" readonly>
                        <input class="form-control" name="id1" id="id1" type="hidden" >
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
                    <option value="" selected disabled> -- Selectionner une catégorie -- </option>
                    @foreach($classes as $classe)  
                    <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_${productCount}" id="product_${productCount}" class="form-control"   required   >
                 </select>
            </td>


            <td>
                <input type="text" class="form-control" id="prix_achat_${productCount}" name="prix_achat_${productCount}"   >
            </td>
            <td>
                <input type="number" class="form-control" id="quantite_${productCount}" name="quantite_${productCount}"   onchange="myFunction()">
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
                            $('select[name="product_'+x+'"]').append('<option disabled > -- Selectionner un produit  -- </option>');

                            $.each(data, function(key, value) {
                               
                                console.log('key : ',key)
                                console.log('value : ',value)
                                console.log('productCount ', productCount)
                       
                                for(var i=2 ; i<= productCount; i++)
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
                console.log('AJAX load did not work ');
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
