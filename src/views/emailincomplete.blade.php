<h3>Hi {{$name}} {{$surname}},<h3>

<p>Following are the incomplete course list</p>

<ul>
  @foreach($courses as $course)
  <li>{{$course}}</li>
  @endforeach
<ul>
