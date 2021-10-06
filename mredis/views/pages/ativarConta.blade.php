
@extends('pages/timestamp/layouts/default')

@section('content')
	
	<div class="container">
		<div style="padding:50px 0px;text-align:center;">
			<form id="formAtivar" action="{{route('formAtivarContaS')}}" name="form" method="post">
				<h4>
					Obrigado por querer adquirir os nossos serviços! 
					<br><br>
					Para terminar a cção terá de Ativar conta!
				</h4>
				<input type="hidden" name="token" value="{{ $token }}">
				<button class="bt">ATIVAR</button>
				<div style="margin-top:20px;text-align:center;">
					<label id="labelAviso"></label>
				</div>
			</form>
		</div>
	</div>


@stop

@section('css')
<link href="https://use.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
@stop

@section('javascript')
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
	$('#formAtivar').on('submit',function(e) {
		$('#labelAviso').html('');
	 	var form = $(this);
		e.preventDefault();
	 	$.ajax({
	   		type: "POST",
	   		url: form.attr('action'),
	   		data: new FormData(this),
	   		contentType: false,
	   		processData: false,
	   		cache: false,
	   		headers:{ 'X-CSRF-Token':'{!! csrf_token() !!}' }
	 	})
	 	.done(function(resposta){
	   	//console.log(resposta);
	   		try{ resp=$.parseJSON(resposta); }
	    	catch (e){
	        	if(resposta){
	        		$('#labelAviso').css('color','red');
	    			$('#labelAviso').html(resposta);
	    		}
	        	return;
	    	}
	    
	    	if(resp.estado=='sucesso'){
	    		$('#labelAviso').css('color','green');
	    		$('#labelAviso').html(resp.mensagem);	
	    		window.location="{{ route('loginTimePage') }}";
	    	}
	 	});
	});
</script>
@stop