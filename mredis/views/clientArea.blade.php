
@extends('pages/timestamp/layouts/default')

@section('content')
	<div class="container">
		<div style="padding:50px 0px;">
			<div class="row">
				<div class="col-md-4">
					<a href="{{ route('clientTimePage') }}"><div style="border:1px solid #4860AD;padding:10px 15px;font-size:18px;margin-bottom:10px;color:#4860AD;">
					Dados da conta</div></a>
					<a href="{{ route('clientTimeApiPage') }}"><div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">Dados para API</div></a>
					<a href="{{ route('clientTimePagPage') }}"><div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">
					Dados de Pagamento</div></a>
					<a href="{{ route('logoutContaS') }}"><div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">
					Terminar Sessão</div></a>
				</div>
				<div class="col-md-8">
					<div style="margin-bottom:50px;">
						<div>
							<h4 style="margin-bottom:20px;">Pacotes adquiridos</h4>
							@if(count($user_conta) > 0) 
								@foreach($user_conta as $conta)
									<label style="border:1px solid #000;width:200px;padding:10px;margin-right: 10px;" onclick="showDadosEdit({{ $conta->id }});">
										<h5>Dados da conta</h5>
										<label>Nome: {{ $conta->nome_conta }}</label>
										<label>E-mail: {{ $conta->email }}</label>
										<label>Morada: {{ $conta->morada }}</label>
										<label>Nif: {{ $conta->nif }}</label>

										<label style="text-decoration: underline red;font-size:16px;">Pacotes adquiridos :</label>

									</label>
								@endforeach

							@else
								<label class="lb">O cliente ainda não tem conta associadas.</label>
							@endif
						</div>
						

						<button class="bt" onclick="showConta();">Adicionar Conta</button>
					</div>
					

					<form id="formAddConta" action="{{route('formAddConta')}}" name="form" method="post" style="display:none;">
						{!! csrf_field() !!}
						<div>
							<h4 style="margin-bottom:20px;">Adicionar de conta</h4>

							<label class="lb">Nome *</label>
							<input class="ip" type="" name="nome">
							<label class="lb">E-mail *</label>
							<input class="ip" type="" name="email">
							<label class="lb">Contacto *</label>
							<input class="ip" type="" name="contacto">
							<label class="lb">Morada *</label>
							<input class="ip" type="" name="morada">
							<label class="lb">Rua</label>
							<input class="ip" type="" name="rua">
							<label class="lb">Código-Postal *</label>
							<input class="ip" type="" name="codigo_postal">
							<label class="lb">Localidade *</label>
							<input class="ip" type="" name="localidade">
							<label class="lb">País *</label>
							<input class="ip" type="" name="pais">
							<label class="lb">NIF *</label>
							<input class="ip" type="" name="nif">

							<div>
								<label id="labelAviso"></label>
							</div>

							<button class="bt" type="submit">Criar Conta</button>
							
						</div>
					</form>

					@foreach($user_conta as $conta)
						<form id="formEditConta_{{ $conta->id }}" action="{{route('formAddConta')}}" name="form" method="post" style="display:none;">
							{!! csrf_field() !!}
							<div>
								<h4 style="margin-bottom:20px;">Editar de conta {{ $conta->nome_conta }}</h4>

								<input class="ip" type="hidden" name="id_conta" value="{{ $conta->id }}">

								<label class="lb">Nome *</label>
								<input class="ip" type="" name="nome" value="{{ $conta->nome_conta }}">
								<label class="lb">E-mail *</label>
								<input class="ip" type="" name="email" value="{{ $conta->email }}">
								<label class="lb">Contacto *</label>
								<input class="ip" type="" name="contacto" value="{{ $conta->contacto }}">
								<label class="lb">Morada *</label>
								<input class="ip" type="" name="morada" value="{{ $conta->morada }}">
								<label class="lb">Rua</label>
								<input class="ip" type="" name="rua" value="{{ $conta->rua }}">
								<label class="lb">Código-Postal *</label>
								<input class="ip" type="" name="codigo_postal" value="{{ $conta->codigo_postal }}">
								<label class="lb">Localidade *</label>
								<input class="ip" type="" name="localidade" value="{{ $conta->localidade }}">
								<label class="lb">País *</label>
								<input class="ip" type="" name="pais" value="{{ $conta->pais }}">
								<label class="lb">NIF *</label>
								<input class="ip" type="" name="nif" value="{{ $conta->nif }}">

								<div>
									<label id="labelAviso_{{ $conta->id }}"></label>
								</div>

								<button class="bt" type="submit">Criar Conta</button>
								
							</div>
						</form>
					@endforeach
					
					
					

				</div>
			</div>
		</div>
	</div>
@stop

@section('css')
<link href="https://use.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
@stop

@section('javascript')
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	function showConta() {
		$('#formAddConta').show();
	}
</script>

<script>
	function showDadosEdit(id){
		@foreach($user_conta as $conta)
			$('#formEditConta_'+{!! $conta->id !!}).hide();
		@endforeach
		$('#formEditConta_'+id).show();

	}

	$('#formAddConta').on('submit',function(e) {
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
		    }
	 	});
	});

	@foreach($user_conta as $conta)
		$('#formEditConta_'+{!! $conta->id !!}).on('submit',function(e) {
			$('#labelAviso_'+{!! $conta->id !!}).html('');
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
			   	try{ resp=$.parseJSON(resposta); }
			    catch (e){
			        if(resposta){
			        	$('#labelAviso_'+{!! $conta->id !!}).css('color','red');
			    		$('#labelAviso_'+{!! $conta->id !!}).html(resposta);
			    	}
			        return;
			    }
			    

			    if(resp.estado=='sucesso'){
			    	$('#labelAviso_'+{!! $conta->id !!}).css('color','green');
			    	$('#labelAviso_'+{!! $conta->id !!}).html(resp.mensagem);

			    }
		 	});
		});
	@endforeach
</script>
@stop