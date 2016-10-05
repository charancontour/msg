@extends('app')

@section('content')
<div class="container-fluid">
	@if(Session::has('flash_message'))
		<div class="flash_messages">
			<h4>{{Session::get('flash_message')}}</h4>
			<span class="close">&times;</span>
		</div>
	@endif

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Broadcast a Message to users</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/broadcastmessage') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Select Location</label>
							<div class="col-md-6">
								<select name="locationid" required>
									<option value="0">All</option>
									<?php $locations = App\Location::all() ?>
									@foreach($locations as $location)
										@if($location->location_name !== "David Lloyd")
											<option value="{{$location->id}}">{{$location->location_name}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Message Text</label>
							<div class="col-md-6">
								<input type="textarea" class="form-control" name="message_text" value="{{ old('message_text') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button class="btn btn-primary">BroadCast</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
		<a href="emailincompleteusercourses" ><button type="submit" class="btn btn-primary">Email users with incomplete courses</button></a>
</div>
@endsection
