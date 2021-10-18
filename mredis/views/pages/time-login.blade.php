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
		<label class="py-3 text-center text-black" id="labelAviso"></label>
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
  	     // data: new FormData(this),
          dataType: "JSON",
	     
          headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' },

		 success: function(resposta) {

			resp=$.parseJSON(resposta);

			if(resp.estado=='sucesso'){
		    	
				console.log(resposta)
				$('#labelAviso').css('color','green');
		    	$('#labelAviso').html(resp.message);
               
		      	//e.preventDefault();
		    }
			if(resposta!='' || resposta!=null  ){

				console.log(resposta)
				$('#labelAviso').css('color','green');
		    	$('#labelAviso').html(resposta);
			}
    	},
    	error: function(resposta){

			console.log(resposta)
			$('#labelAviso').css('color','red');
		    $('#labelAviso').html(resposta);
    	}

	    })
	});
</script>
@stop