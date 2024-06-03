@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
	.current-photo-label {
		color: #ff6347; /* Tomato color */
		font-family: 'Arial', sans-serif;
		font-weight: bold;
		font-size: 14px;
	}
</style>
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Dishes</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Dishes Managment</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')


<!-- validation  strat -->
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
<!-- validation  end -->


<!-- row -->
<div class="row">
		<!--div-->
		<div class="col-xl-12">
		<div class="card mg-b-20">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-0"> Dishes Table </h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
		
			<div class="card-body">
				<a class="btn ripple btn-warning" data-target="#modaldemo6" data-toggle="modal" href="">Add New Dish</a>
				</div>
			</div>
		
			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table key-buttons text-md-nowrap">
						<thead>
							<tr>
								<th class="border-bottom-0">#N</th>
								<th class="border-bottom-0">الأسم</th>
								<th class="border-bottom-0">السعر</th>								
								<th class="border-bottom-0">الوصف</th>								
								<th class="border-bottom-0">الصنف</th>								
								<th class="border-bottom-0">الصورة</th>								
							</tr>
						</thead>
						<tbody>
							<?php $i = 1;?>
							@foreach($dishes as $dish)					
							<tr>
								<td>{{$i++}}</td>
								<td>{{$dish->name}}</td>
								<td>{{$dish->price}}</td>
								<td>{{$dish->descraption}}</td>
								<td>{{ $dish->category ? $dish->category->name : 'No Category' }}</td>
								<td>                
									<img src="{{ asset('images/' . $dish->photo) }}" alt="{{ $dish->name }}" width="100" height="50">
								</td>
								<td>
                                       
									<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
										data-id="{{$dish->id}}"
										data-name="{{$dish->name}}" 
										data-price="{{$dish->price}}"
										data-descraption="{{$dish->descraption}}"
										data-cat_id="{{$dish->cat_id}}"
										data-photo="{{$dish->photo}}"
										data-toggle="modal"
										href="#exampleModal2" title="Edit"><i class="las la-pen"></i></a>
								
									<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
										data-id="{{$dish->id}}" 
										data-name="{{$dish->name}}" 
										data-toggle="modal"
										 href="#modaldemo9" title="Delete"><i
											class="las la-trash"></i></a>
                                      
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
</div>
<!-- /row -->


<!-- Add modal -->
		<div class="modal" id="modaldemo6">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> Add New Dish</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{route('dishes.store')}}" method="post" enctype="multipart/form-data">
							@csrf 
							<div class="form-group">
								<label for="exampleInputEmail1"> الأسم :</label>
								<input type="text" class="form-control" id="name" name="name">

								<label for="exampleInputEmail1"> السعر :</label>
								<input type="number" class="form-control" id="price" name="price" >

								<label for="exampleInputEmail1"> الوصف :</label>
								<input type="text" class="form-control" id="descraption" name="descraption">

								<label for="exampleInputEmail1"> الصنف :</label>
								<select id="cat_id" name="cat_id" class="form-control" required>
									<option value="" disabled selected>Select a category</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
								<label for="exampleInputEmail1"> الصورة :</label>
								<input type="file" class="form-control" id="photo" name="photo">
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-success">إضافة</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
							</div>
						</form>						
					</div>
				</div>
			</div>
		</div>
<!--End Add modal -->

</div>
    <!-- edit modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					@if($dishes->isEmpty())
						<p> No Category Found!</p>  
				    @else
					<form id="updateDishForm" method="post" autocomplete="off" enctype="multipart/form-data">
					@method('PUT')
					@csrf
					<div class="form-group">
						
						<input type="hidden" id="updateDishId" name="dish_id" value="">

								<label for="exampleInputEmail1"> الأسم :</label>
								<input type="text" class="form-control" id="name" name="name">

								<label for="exampleInputEmail1"> السعر :</label>
								<input type="number" class="form-control" id="price" name="price">

								<label for="exampleInputEmail1"> الوصف :</label>
								<input type="text" class="form-control" id="descraption" name="descraption">

								<label for="exampleInputEmail1"> الصنف :</label>
								<select id="cat_id" name="cat_id" class="form-control" required>
									<option value="" disabled selected>Select a category</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ $category->id == $dish->cat_id ? 'selected' : '' }}>
											{{ $category->name }}
										</option>
									@endforeach
								</select>

								<label for="exampleInputEmail1"> الصورة :</label>
								<input type="file" class="form-control" id="photo" name="photo">
								@if($dish->photo)
									<div>
										<label for="exampleInputEmail1" class="current-photo-label"> الصورة الحالية: </label>
										<span>{{ $dish->photo }}</span>
										<input type="hidden" class="form-control" name="old_photo" value="{{ $dish->photo }}">
									</div>
								@endif
					</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                </div>
                </form>
				
            </div>
        </div>
    </div>
	
<!-- end edit model -->


<!-- delete model -->
<div class="modal" id="modaldemo9">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Delete Company</h6><button aria-label="Close" class="close" data-dismiss="modal"
					type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form id="deleteDishForm" method="post" autocomplete="off">
				@method('DELETE')
				@csrf
				<div class="modal-body">
					<p>Are you sure you want to delete?</p><br>
					<input type="hidden" id="deleteDishId" name="dish_id" value="">					<input class="form-control" name="name" id="name" type="text" readonly>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
					<button type="submit" class="btn btn-danger">Delete</button>
				</div>
		</div>
		</form>
		@endif
	</div>
</div>

<!-- end delete model -->

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var price = button.data('price')
        var descraption = button.data('descraption')
        var cat_id = button.data('cat_id')
       // var photo = button.data('photo')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #price').val(price);
        modal.find('.modal-body #descraption').val(descraption);
        modal.find('.modal-body #cat_id').val(cat_id);
       // modal.find('.modal-body #photo').val(photo);									
	})
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
       
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })

</script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const modalLinks = document.querySelectorAll('.modal-effect');
	
		modalLinks.forEach(link => {
			link.addEventListener('click', function (event) {
				// Get the data-id value
				const dataId = event.currentTarget.dataset.id;
	
				// Update Form
				const updateForm = document.getElementById('updateDishForm');
				const updateHiddenInput = document.getElementById('updateDishId');
				updateHiddenInput.value = dataId;
				updateForm.action = `{{ route('dishes.update', '') }}/${dataId}`;
	
				// Delete Form
				const deleteForm = document.getElementById('deleteDishForm');
				const deleteHiddenInput = document.getElementById('deleteDishId');
				deleteHiddenInput.value = dataId;
				deleteForm.action = `{{ route('dishes.destroy', '') }}/${dataId}`;
			});
		});
	});
	</script>
	
	
@endsection  