@extends('app')

@section('contents')
@if($items)
	    <br>
	    <h4>The weather in {{ $items->name}}  : {{ $items->weather[0]->main}} </h4>
	    <br>

	<h5>Sightseeing tips!</h5>    
	<ul>
	@foreach ($items->tripInfo->features as $info)
	    <li>{{$info->properties->name}}</li>
	@endforeach
	</ul>
@endif

<form method="post" action="/connect">
	@csrf
  <div class="form-group">
    <label for="location">Where do you want to have information for?</label>
    <input type="location" class="form-control" id="exampleInputlocation1" aria-describedby="locationHelp" placeholder="Enter location" name="location">
  </div>
  <button type="submit" class="btn btn-primary">Check! </button>
</form>


@endsection