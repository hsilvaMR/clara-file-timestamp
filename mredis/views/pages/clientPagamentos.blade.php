@extends('pages/timestamp/layouts/default')

@section('content')

<div class="container">
	<div style="padding:50px 0px;">
		<div class="row">
			<div class="col-md-4">
				<a href="{{ route('clientTimePage') }}">
					<div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">
						Dados da conta</div>
				</a>
				<a href="{{ route('clientTimeApiPage') }}">
					<div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">Dados para
						API</div>
				</a>
				<a href="{{ route('clientTimePagPage') }}">
					<div
						style="border:1px solid #4860AD;padding:10px 15px;font-size:18px;margin-bottom:10px;color:#4860AD;">
						Dados de Pagamento</div>
				</a>
				<a href="{{ route('logoutContaS') }}">
					<div style="border:1px solid #ccc;padding:10px 15px;font-size:18px;margin-bottom:10px;">
						Terminar Sessão</div>
				</a>
			</div>
			<div class="col-md-8">
				<div>

					<li class="lb">Faturas dos Pagamentos</li>
					<li class="lb">Pagamentos efetuados</li>
					<li class="lb">Pagamentos a expirar</li>
					<li class="lb">Conta auto renovação</li>
				</div>
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

@stop