@extends('layouts/time/default')

@section('content')
	<form action="{{ route('loginPostTime') }}" id="form-login" method="post">

		{!! csrf_field() !!}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div style="margin-bottom:20px;">
			<label>EMAIL</label><br>
			<input id="username" type="email" name="username"><br><br>
			<label>PASSWORD</label><br>
			<input id="password" type="password" name="password">
		</div>
		

		<button type="submit">ENTRAR</button>
	</form>

@stop


@section('css')
@stop


@section('javascript')
<script>

	$('#form-login').on('submit',function(e) {
	    e.preventDefault();
	    var form = $('#form-login');

	    $.ajax({
	      type: "POST",
	      url: form.attr('action'),
	      data: form.serialize(),
	    })
	    .done(function(resposta) {
	    	console.log(resposta);
	    
	    });
	});
</script>
@stop