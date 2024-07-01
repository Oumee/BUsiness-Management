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
            <h4 class="content-title mb-0 my-auto">Achats</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Modification d'achat</span>
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
 @php
     $productCount = 1;
 @endphp
 
  
    <!-- Show and edit -->
    
                <div class="modal-header">
                         <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="/achats/update" method="post" autocomplete="off">
                      
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                            
                            
                            <!-- Input pour stocker l'ID -->
                               <input type="hidden" name="id" id="id" value="{{$achats->id}}">
                              
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ $achats->date }}">
                                 </div>
                              
                    <table class="table table-bordered"   id="produits">

                     <tr>
                         <th>Catégorie</th>
                         <th>Produit</th>
                         <th>Prix d'achat </th>
                         <th>Quantité</th>
                         <th>Opération</th>
                     </tr>
   
                   
                     
                    
             <tr>
            <script> 
             
             let varCount=1;

            </script>


      @foreach($transaction_achats as $ts)

           @php
                $productCount++;
           @endphp

            <script> 
            varCount++;
            console.log('pro :',varCount)
            </script>
            
              <td>
                <div class="form-group">
                <select name="Section_{{$productCount}}" class="form-control" 
                id="selection_{{$productCount}}" 
                {{-- onchange="Produits({{$productCount}})"  --}} 
                readonly>
                <option value="" selected disabled > -- Selectionner une catégorie -- </option>
                @foreach($classes as $classe)  
                <option value="{{ $classe->id }}">
                {{ $classe->section_name }}
                </option>
                @endforeach
                </select>
                    </div>
                </td>
 
            <td> 
                <div class="form-group">
                    <select     name="product_{{$productCount}}" id="product_{{$productCount}}"  class="form-control"   readonly>
                        <option value="{{ $ts->product->id}}">{{ $ts->product->designation }}</option>
                    </select>
                </div> 
            </td>
 

            <td>
                <div class="form-group">
                    <input type="text" class="form-control" id="prix_achat_{{ $productCount }}" name="prix_achat_{{ $productCount }}"    value="{{ $ts->prix_achat }}" onchange="myFunction()">
                </div>   
            </td>


            <td>
                <div class="form-group">
               
                    <input type="number" class="form-control" id="quantite_{{$productCount}}" name="quantite_{{$productCount}}"  value="{{ $ts->quantite }}" onchange="myFunction();  UpdateQuantites({{$productCount}})">
               
                </div>
            </td>
         
                <div class="form-group">
                <input type="hidden" class="form-control" id="quantite_ancien_{{$productCount}}" name="quantite_ancien_{{$productCount}}"  value="{{ $ts->quantite}}"  >
                </div>
          

             <td>

                  <button  type="button" class="btn btn-danger" onclick="removeParentDiv(this);  myFunction()   " >🚮</button>
 
                </td>

            
      </tr>

    @endforeach
       </table>

              <button type="button" class="btn btn-secondary" onclick="addProduct({{ ++$productCount }})">Ajouter un produit 🛒</button>

             <div class="form-group">
                <label for="exampleInputEmail1">Total HT</label>
                <input type="text" class="form-control" id="total_ht" name="total_ht" value="{{$achats->total_ht}}" readonly>
            </div>


            <div class="form-group">

                            <label for="inlineFormCustomSelectPref" class="control-label">  Taux de taxe  </label>
                            <select name="taux" id="taux" class="form-control" onchange="myFunction()">
                                <!--placeholder-->
                                 <option value=" 2%">2%</option>
                                 <option value="5%">5%</option>

                            </select>
            </div>
                      
                        
                        <div class="form-group">
                          
                            <label for="exampleInputEmail1">Total TTC</label>
                            <input type="text" class="form-control" id="total_ttc" name="total_ttc" value="{{$achats->total_ttc}}" readonly>
                       
                        </div>
                      
                        <div class="form-group">
                            <label class="control-label" for="inlineFormCustomSelectPref">Fournisseur</label>
                            <select name="nom" id="nom" class="form-control"  >
                                <option value="{{ $achats->fournisseur->nom }}">{{ $achats->fournisseur->nom }}</option>
                                @foreach ($fournisseurs as $item)
                                    <option value="{{ $item->nom }}">{{ $item->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Quitter</button>
                </div>
                </form>
         


    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')


<!-- Add Produit au panier -->
 
<script>
   
function addProduct(x) {

        //  if(!varCount)
        //  varCount=x;
        
         varCount++;

        console.log('productCount value: ',varCount);

        const productDiv = document.createElement('tr');

        productDiv.className = 'table table-bordered';

        console.log('yes');
        productDiv.innerHTML = `
                <td>
                
                <div class="form-group">
                <select name="Section_${varCount}" class="form-control" id="selection_${varCount}" onchange="Produits(${varCount})"  >
                    <option value="" selected disabled> -- Selectionner une catégorie  -- </option>
                    @foreach($classes as $classe)  
                    <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                    @endforeach
                </select>
                </div>

                </td>

                <td>

                <div class="form-group">
                <select name="product_${varCount}" id="product_${varCount}" class="form-control"  ></select>
                </div>

            </td>

            <td>
                <div class="form-group">
                <input type="text" class="form-control" id="prix_achat_${varCount}" name="prix_achat_${varCount}"   >
                </div>
            </td>

                 <input type="hidden" class="form-control" id="quantite_ancien_${varCount}" name="quantite_ancien_${varCount}"    onchange="myFunction()">
             
                <td>
                <div class="form-group">
                <input type="number" class="form-control" id="quantite_${varCount}"  name="quantite_${varCount}"  onchange="myFunction();   ">
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeParentDiv(this);  myFunction()">🚮</button>
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
                <select name="Section_${productCount}" class="form-control" id="selection_${productCount}" onchange="Produits(${productCount})"  >
                    <option value="" selected disabled> -- Selectionner une catégorie  -- </option>
                    @foreach($classes as $classe)  
                    <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_${productCount}" id="product_${productCount}" class="form-control" onchange="CurrentQuantites(${productCount})"></select>
            </td>
            <td>
                <input type="text" class="form-control" id="prix_achat_${productCount}" name="prix_achat_${productCount}"   >
            </td>
            <td>
                <input type="text" class="form-control" id="quantite_${productCount}" name="quantite_${productCount}"    onchange="myFunction()">
            </td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeParentDiv(this); myFunction()" >🚮</button>
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
 
         @foreach($transaction_achats as $ts)
 
        var product_{{$ts->id}} = button.data('product_{{$ts->id}}');
        var prix_achat_{{$ts->id}} = button.data('prix_achat_{{$ts->id}}');
        var quantite_{{$ts->id}} = button.data('quantite_{{$ts->id}}');

         @endforeach
 

        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #total_ht').val(total_ht);
        modal.find('.modal-body #total_ttc').val(total_ttc);
        modal.find('.modal-body #nom').val(nom);

         @foreach($transaction_achats as $ts)
         
        modal.find('.modal-body #product_{{$ts->id}}').val(product_{{$ts->id}});
        modal.find('.modal-body #prix_achat_{{$ts->id}}').val(prix_achat_{{$ts->id}});
        modal.find('.modal-body #quantite_{{$ts->id}}').val(quantite_{{$ts->id}});

         @endforeach
        
       
 
    });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
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
                            console.log('success')
                            $('select[name="product_'+x+'"]').empty();
                            $('select[name="product_'+x+'"]').append('<option > -- Selectionner un produit -- </option>');
                            $.each(data, function(key, value) {
                                        for(var i=2 ; i<=varCount; i++)
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
                           
                           
                            if(flag===0)
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
    

 function CurrentQuantites(elem)
    {
        var x = elem;

        var ProduitId = document.getElementById("product_"+x).value;
        var initQuantite = document.getElementById("quantite_"+x).value;
         
       
        console.log('hoi : ',elem)
        console.log('ProduitId : ',ProduitId)
        console.log('initQuantite : ',initQuantite)

        if (ProduitId) {
                    $.ajax({
                        url: "{{ URL::to('produit') }}/" + ProduitId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                      
                            $.each(data, function(key, value) {
                            $('input[name="quantite_'+x+'"]').attr({
                                type: 'number',
                                min: value ,
                                
                                }).on('input', function() {
                                var newValue = $(this).val(); // Récupérer la nouvelle valeur de l'input
                                console.log("La nouvelle valeur est : " + newValue);
                                // Autres actions à effectuer en fonction de la nouvelle valeur
                            });

                            });
                        },
                    });
    
                } else {
                    console.log('AJAX load did not work');
                }    

    }
    
    </script>

<script>

function UpdateQuantites(elem)
    {
        var x = elem;

        var ProduitId = document.getElementById("product_"+x).value;
        var initQuantite = document.getElementById("quantite_ancien_"+x).value;
         
       
        console.log('hoi : ',elem)
        console.log('ProduitId : ',ProduitId)
        console.log('initQuantite : ',initQuantite)

        if (ProduitId) {
                    $.ajax({
                        url: "{{ URL::to('produitUpdate1') }}/" + ProduitId+"/"+initQuantite,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                      
                            $.each(data, function(key, value) {
                            $('input[name="quantite_'+x+'"]').attr({
                                type: 'number',
                                min: value,
                                // max:   ,
                                }).on('input', function() {
                                var newValue = $(this).val(); // Récupérer la nouvelle valeur de l'input
                                console.log("La nouvelle valeur est : " + newValue);
                                // Autres actions à effectuer en fonction de la nouvelle valeur
                            });

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
    console.log('varCount :', varCount );
    for (var i = 2; i <= varCount; i++) {
         if(document.getElementById("prix_achat_" + i))
        {
            var prix_achat = parseFloat(document.getElementById("prix_achat_" + i).value);
            var quantite = parseFloat(document.getElementById("quantite_" + i).value);
            prix_net += prix_achat * quantite;
        }
    }

    var taux = parseFloat(document.getElementById("taux").value);

    if (isNaN(prix_achat) || prix_achat === 0) {
        alert('Entrez le prix d achat');
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
