@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
   
   <style>
    .required {
        color: red;
        margin-left: 5px; /* Espacement entre le texte du label et l'astérisque */
    }
  </style>  
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
{{--       js for image  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 

@section('title')
    Produits
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Produits</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                listes des produits</span>
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
                @can('ajouter_produit')
                <a class="btn btn-primary" data-effect="effect-scale"
                data-toggle="modal" href="#modaldemo8"> Ajouter un produit</a>
                @endcan          
                @can('importer_produit')      
                            <h5>Importer des produits</h5>
                            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="excel">
                                <button type="submit">Importer</button>
                            </form>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">référence</th>
                                <th class="border-bottom-0">désignation</th>
                                <th class="border-bottom-0">Catégorie</th>
                                <th class="border-bottom-0">code à barre</th>
                                <th class="border-bottom-0">prix d'achat</th>
                                <th class="border-bottom-0">prix de vente</th>
                                <th class="border-bottom-0">quantité</th>
                                <th class="border-bottom-0">image</th>
                                <th class="border-bottom-0">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($products as $x)
                                <?php $i++; ?>
                                 <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->reference }}</td>
                                    <td>{{ $x->designation }}</td>
                                    <td>{{ $x->section->section_name }}</td>
                                    <td>{{ $x->codebare }}</td>
                                    <td>{{ $x->prix_achat }}</td>
                                    <td>{{ $x->prix_vente }}</td>
                                    <td>{{ $x->quantite }}</td>
                                    <td>
                                        <img src="{{ asset($x->image) }}" width="50" height="50" class="rounded-circle img-thumbnail">
                                    </td>
                                                                        
                                    <td>
                                        @can('modifier_produit')
                                            
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                        data-id="{{ $x->id }}" 
                                        data-reference="{{ $x->reference }}"
                                        data-designation="{{ $x->designation }}" 
                                        data-code_bare="{{ $x->codebare }}"
                                        data-section_name="{{ $x->section->section_name }}"
                                        data-prix_achat="{{ $x->prix_achat }}"
                                        data-prix_vente="{{ $x->prix_vente }}"
                                        data-quantite="{{ $x->quantite }}"
                                  
                                        data-toggle="modal"
                                        href="#exampleModal2" 
                                        title="modifier">
                                        <i class="las la-pen"></i>
                                     </a>
                                     @endcan
                                     @can('modifier_produit')
                                     
                                             <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-reference="{{ $x->reference }}"
                                                data-toggle="modal" href="#modaldemo9" title="supprimer"><i class="las la-trash"></i>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Ajouter un produit</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reference">Référence<span class="required">*</span></label>
                            <input type="text" class="form-control" id="reference" name="reference">
                        </div>
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Catégorie<span class="required">*</span></label>
                        <select name="section_id" id="section_id" class="form-control" required>
                            <option value="" selected disabled> -- Selectionner une catégorie  --</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->section_name }}</option>
                            @endforeach
                            
                        </select>
                        <div class="form-group">
                            <label for="designation"> Désignation <span class="required">*</span></label>
                            <input type="text" class="form-control" id="designation" name="designation">
                        </div>
                    
                        <div class="form-group">
                            <label for="code_bare">Code à barre<span class="required">*</span></label>
                            <input type="text" class="form-control" id="code_bare" name="codebare">
                        </div> 

                        <div class="form-group">
                            <label for="code_bare">Image<span class="required">*</span></label>
                            <input type="file"  class="form-control"  id="image" name="image"  >
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
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier un produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="products/update" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                       
                        
                        <input type="hidden"  name="id" id="id" value="">


                        <div class="form-group">
                            <label for="exampleInputEmail1">Réference </label>
                            <input type="text" class="form-control" id="reference" name="reference">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Désignation</label>
                            <input type="text" class="form-control" id="designation" name="designation">
                        </div>

                        <div class="form-group">
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Catégorie</label>
                        <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                        @foreach ($classes as $classe)
                         <option >{{ $classe->section_name }}</option>
                        @endforeach     
                        </select>
                        </div>  

                        <div class="form-group">
                            <label for="code_bare">Code à barre</label>
                            <input type="text" class="form-control" id="code_bare" name="code_bare">
                        </div>
 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Prix D'achat</label>
                            <input type="text" class="form-control" id="prix_achat" name="prix_achat">
                        </div>
  
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Prix De vente</label>
                            <input type="text" class="form-control" id="prix_vente" name="prix_vente">
                        </div>

                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantité</label>
                            <input type="text" class="form-control" id="quantite" name="quantite">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Supprimer un produit</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="products/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p> Voulez-vous vraiment supprimer ?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="reference" id="reference" type="text" readonly>
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
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var reference = button.data('reference');
        var designation = button.data('designation');
        var section_name = button.data('section_name');
        var code_bare = button.data('code_bare');
        var prix_achat = button.data('prix_achat');
        var prix_vente = button.data('prix_vente');
        var quantite = button.data('quantite');
       

        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #reference').val(reference);
        modal.find('.modal-body #designation').val(designation);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #code_bare').val(code_bare);
        modal.find('.modal-body #prix_achat').val(prix_achat);
        modal.find('.modal-body #prix_vente').val(prix_vente);
        modal.find('.modal-body #quantite').val(quantite);
     });
</script>


<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var reference = button.data('reference')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #reference').val(reference);
    })

</script>

@endsection
