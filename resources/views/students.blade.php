<!DOCTYPE html>
<html>
<head>
<title>This is the Ajax crud function</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card-header">
				Student
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentModal">Add New</button>
			</div>

			<div class="card-body">
				<table id="studentTable" class="table">
					<thead>
						<tr>
							<th>First name</th>
							<th>Last name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Action</th>
						</tr>
					</thead>
					
					<tbody>
						@foreach($students as $studentval)
						<tr>
							<td>{{ $studentval->firstname }}</td>
							<td>{{ $studentval->lastname }}</td>
							<td>{{ $studentval->email }}</td>
							<td>{{ $studentval->phone }}</td>
							<td><a href="javascript:void(0)" onclick="editStudent({{$studentval->id}})" class="btn btn-primary">Edit</a>
								<a href="javascript:void(0)" onclick="deleteStudent({{$studentval->id}})" class="btn btn-danger">Delete</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="studentForm">
        	@csrf
        	<div class="form-group">
        		<label for="firstname">First Name</label>
        		<input type="text" name="firstname" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="lastname">Last Name</label>
        		<input type="text" name="lastname" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="email">Email</label>
        		<input type="text" name="email" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="phone">Phone</label>
        		<input type="text" name="phone" class="form-control">
        	</div>

        	<div class="form-group">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="submit" class="btn btn-primary">Save</button>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Edit Modal -->
<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="studentEditForm">
        	@csrf
        	<input type="hidden" name="id" id="id">
        	<div class="form-group">
        		<label for="firstname">First Name</label>
        		<input type="text" name="firstname" id="firstname" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="lastname">Last Name</label>
        		<input type="text" name="lastname" id="lastname" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="email">Email</label>
        		<input type="text" name="email" id="email" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="phone">Phone</label>
        		<input type="text" name="phone" id="phone" class="form-control">
        	</div>

        	<div class="form-group">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="submit" class="btn btn-primary">Save</button>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>





<script>
	$('#studentForm').submit(function(e){
		e.preventDefault();
		var firstname 	= $("input[name=firstname]").val();
		var lastname 	= $("input[name=lastname]").val();
		var email 		= $("input[name=email]").val();
		var phone 		= $("input[name=phone]").val();
		var _token 		= $("input[name=_token]").val();

		$.ajax({
			url:"{{ url('/add-student') }}",
			type:"post",
			dataType: 'json',
			data:{
				firstname:firstname,
				lastname:lastname,
				email:email,
				phone:phone,
				_token:_token
			},
			success:function(response){
				console.log(response);
				// The "append" is inserted into bottom position and "prepend" is inserted on top position
				// $('#studentTable tbody').append('<tr><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td>'+phone+'</td></tr>');

				$('#studentTable tbody').prepend('<tr><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td>'+phone+'</td></tr>');


				$('#studentModal').modal('toggle');
				$('#studentForm')[0].reset();

				$('body').load('{{url('students')}}');
			}
		});
	});
</script>


<script>
	function editStudent(id){
		$.get('students/'+id, function(student){
			$('#id').val(student.id);
			$('#firstname').val(student.firstname);
			$('#lastname').val(student.lastname);
			$('#email').val(student.email);
			$('#phone').val(student.phone);

			$('#studentEditModal').modal('toggle');
			
		});
	}

	$('#studentEditForm').submit(function(e){
		e.preventDefault();
		var id = $('#id').val();
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var _token = $('input[name=_token]').val();


		$.ajax({
			url:"{{ url('/student') }}",
			type:'PUT',
			data:{
				id:id,
				firstname:firstname,
				lastname:lastname,
				email:email,
				phone:phone,
				_token:_token
			},

			success:function(response){
				$('#sid'+response.id + 'td:nth-child(1)').text(response.firstname);
				$('#sid'+response.id + 'td:nth-child(2)').text(response.lastname);
				$('#sid'+response.id + 'td:nth-child(3)').text(response.email);
				$('#sid'+response.id + 'td:nth-child(4)').text(response.phone);

				$('#studentEditModal').modal('toggle');
				$('#studentEditForm')[0].reset();

				$('body').load('{{url('students')}}');
				// window.location = "{{ url('students') }}";
			}
		});
	})
</script>

<script>
	function deleteStudent(id){
		if(confirm('Are you sure to delete this Record')){
			$.ajax({
				url: 'students/'+id,
				type: 'delete',
				data:{
					_token: $("input[name=_token]").val()
				},

				success:function(response){
					$('#sid'+id).remove();
					$('body').load('{{url('students')}}');
				}
			})
		}
	}
</script>
</body>
</html>