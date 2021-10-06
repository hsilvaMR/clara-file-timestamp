
@extends('pages/timestamp/layouts/default')

@section('content')

<div class="container">
	<div style="padding:50px 0px;">
		
		<h4 style="text-align:center;">Iniciar sessão / Registo</h4>

		<form id="formLogin" action="{{route('formLSelos')}}" name="form" method="post">
			<div class="row justify-content-md-center">
				<div class="col-md-4">
					<div style="border: 1px solid #ccc;padding:20px;margin-top:30px;">
						<input class="ip" type="text" name="email" placeholder="Endereço de email">
						<input class="ip" type="password" name="password" placeholder="Palavra-passe">
						<div style="text-align:center;"><button class="bt" > Entrar</button></div>


						<div style="margin-top:20px;text-align:center;">
							<label style="margin-bottom:20px;;">Ainda não está registado? <a style="cursor:pointer;" onclick="registarClient();">Registe-se aqui!</a></label><br>
							<label id="labelAviso"></label>
						</div>
					</div>
				</div>
			</div>
		</form>


		<form id="formRegister" action="{{route('formRSelos')}}" name="form" method="post" style="display:none;">
			<div class="row justify-content-md-center">
				<div class="col-md-4">
					<div style="border: 1px solid #ccc;padding:20px;margin-top:30px;">
						<input class="ip" type="text" name="email" placeholder="Endereço de email">
						<input class="ip" type="password" name="password" placeholder="Palavra-passe">
						<div style="text-align:center;"><button class="bt" > Registar</button></div>


						<div style="margin-top:20px;text-align:center;">
							<label style="margin-bottom:20px;">Já tem conta? <a style="cursor:pointer;" onclick="inciarSessao();">Inicie sessão!</a></label><br>
							<label id="labelAviso_2"></label>
						</div>
					</div>
				</div>
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

	function registarClient(){
		$('#formLogin').hide();
		$('#formRegister').show();
		document.getElementById("formLogin").reset();
		document.getElementById("formRegister").reset();
	}

	function inciarSessao(){
		$('#formLogin').show();
		$('#formRegister').hide();
		document.getElementById("formLogin").reset();
		document.getElementById("formRegister").reset();
	}

	$('#formLogin').on('submit',function(e) {
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
	    		window.location="{{ route('clientTimePage') }}";
	    	}
	 	});
	});

	$('#formRegister').on('submit',function(e) {
		$('#labelAviso_2').html('');
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
	        		$('#labelAviso_2').css('color','red');
	    			$('#labelAviso_2').html(resposta);
	    		}
	        	return;
	    	}
	    
	    	if(resp.estado=='sucesso'){
	    		$('#labelAviso_2').css('color','green');
	    		$('#labelAviso_2').html(resp.mensagem);	
	    	}
	 	});
	});
</script>
@stop