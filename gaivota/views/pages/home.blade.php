
@extends('timestamp/layouts/default')

@section('content')

	<div style="padding:50px 0px;text-align:center;">
		<h3 style="margin-bottom:30px;">Pacotes de selos temporais</h3>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div style="border:1px solid #000;padding:30px 0px;">
						<label style="font-size:18px;">Pacote 50</label>

						<div style="margin-top:20px;">50 selos com validade de 1 ano</div>

						<div style="margin-top:20px;font-size:24px;">30 €</div>

						<button class="bt" onclick="comprarSelo('pacote1');">COMPRAR</button>
					</div>
				</div>

				<div class="col-md-4">
					<div style="border:1px solid #000;padding:30px 0px;">
						<label style="font-size:18px;">Pacote 100</label>

						<div style="margin-top:20px;">100 selos com validade de 1 ano</div>
						<div style="margin-top:20px;font-size:24px;">45 €</div>
						<button class="bt" onclick="comprarSelo('pacote2');">COMPRAR</button>
					</div>
				</div>

				<div class="col-md-4">
					<div style="border:1px solid #000;padding:30px 0px;">
						<label style="font-size:18px;">Pacote 500</label>

						<div style="margin-top:20px;">500 selos com validade de 1 ano</div>
						<div style="margin-top:20px;font-size:24px;">200 €</div>
						<button class="bt" onclick="comprarSelo('pacote3');">COMPRAR</button>
					</div>
				</div>
			</div>





			<form id="formCSelos" action="{{route('formCSelos')}}" name="form" method="post">
				<!--DIV COMPRAR SELOS-->
				{{ csrf_field() }}

				<div id="div_compra" style="padding:50px 0px;font-size:14px;display:none;">
					<h4>Compra de Selos</h4>

					<div style="border:1px solid #000;padding:30px 15px;margin-top:20px;text-align:left;">

						<label style="font-size:18px;">Para adquirir Selos siga os três passos seguintes:</label><br><br>
						<li>Comece por selecionar o(s) pacote(s) que deseja adquirir e realize o pagamento com o valor total (com IVA incluído).</li>
						<li>Preencha os dados para envio da Fatura.</li>

						<label style="margin-top:20px;">Os Selos Temporais são emitidos num prazo máximo de oito horas úteis (9h-18h), após recepção do pedido e comprovativo de pagamento.</label>

						<label style="margin-top:20px;">Se deseja adquirir quantidades diferentes das fornecidas acima, por favor contacte-nos através do número +351 000 000 000 (9h-18h) ou do endereço <a style="text-decoration:underline;color:#707070;font-weight:bold;" href="mailto:selos@mredis.com">selos@mredis.com</a>.</label>	
					</div>



					<div style="border:1px solid #000;padding:30px 15px;margin-top:20px;text-align:left;">
						
						<div>
					
							<input type="radio" id="invoiceType1" name="invoiceType1" value="fatura_eletronica" checked="true">
					        <label for="invoiceType1">
					        	<span></span>Fatura Eletrónica
					        </label>


						</div>
						<div style="display: block;margin:0px 0px 10px 25px;">
							<div>
								<label>Autorizo o envio da Fatura Eletrónica para o seguinte endereço de correio eletrónico</label>
								<br>
								<input style="width:calc(100% - 20px);" id="invoiceEmail" name="invoiceEmail" placeholder="xxxxxx@xxxx.xx" type="text" class="ip">
							</div>
						</div>

					</div>




					<div style="border:1px solid #000;padding:30px 15px;margin-top:20px;text-align:left;">
						<h5>Dados para envio da Fatura</h5>

						<div class="row">
							<div class="col-md-8">
								<label>Nome da Entidade</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="nome_entidade">
							</div>
							<div class="col-md-4">
								<label>NIF</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="nif_entidade">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label>Contacto</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="contacto_entidade">
							</div>
							<div class="col-md-6">
								<label>Endereço de email</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="email_entidade">
							</div>
						</div>
						
						<label>Morada</label><span class="tx-red"> *</span>
						<input class="ip" type="input" name="morada_entidade">
						<input class="ip" type="input" name="morada_cont_entidade">

						<div class="row">
							<div class="col-md-4">
								<label>Código-Postal</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="codigo_postal_entidade" placeholder="xxxx-xxx">
							</div>
							<div class="col-md-4">
								<label>Localidade</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="localidade_entidade">
							</div>
							<div class="col-md-4">
								<label>País</label><span class="tx-red"> *</span>
								<input class="ip" type="input" name="pais_entidade">
							</div>
						</div>
						
						
					</div>

					<div style="text-align:left;font-size:12px;"><span class="tx-red">*</span> <label>Campos de submissão obrigatórios.</label></div>

					<div>
						<label id="labelAviso"></label>
					</div>

					<div style="border:1px solid #0C31D4;padding:30px 15px 20px 15px;margin-top:20px;text-align:left;background-color:#C5CFFC;">
						<h5>Valor total: <span id="preco" style="color:#0C31D4;font-weight:bold;"></span> € + IVA</h5>
						<input style="display:none;" id="preco_inicial" type="hidden" name="pacote" value="">
					</div>


					<button class="bt bg-green float-right" id="customButton" type="submit"><i class="fas fa-check"></i> Efetuar Pagamento</button>


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
<!-- Stripe -->
<script src="https://checkout.stripe.com/checkout.js"></script>

<script type="text/javascript">

	var handler = StripeCheckout.configure({
		key: 'pk_test_51J5BxHLOqY4FXPTidBWVoBMdKm4k1F8ZPA1iUIBKi8VEWzY29eud2YDKhrjAyFweq5isEafQpSxQesFSqKzaogEC00G8YHbgsR',
      	image: '',
      	locale: 'pt-BR',
      	token: function(token) {
        	// You can access the token ID with `token.id`.
        	// Get the token ID to your server-side code for use.

        	window.location="";
      	}
    });
 
    /*document.getElementById('customButton').addEventListener('click', function(e) {
        
		// Open Checkout with further options:
      	var preco_inicial = $('#preco_inicial').val();
 
      	handler.open({
        	name: '',
        	description: '',
        	currency: 'EUR',
        	amount: preco_inicial,
        	email:'',
      	});
      	e.preventDefault(); 
    });*/

    // Close Checkout on page navigation:
    window.addEventListener('popstate', function() {
    	handler.close();
    });
	
</script>

<script>
$('#formCSelos').on('submit',function(e) {
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

    	document.getElementById("formCSelos").reset();

    
				/*$('#labelAviso').css('color','green');
				$('#labelAviso').html(resp.mensagem);

				document.getElementById("formCSelos").reset();


				var preco_inicial = $('#preco_inicial').val();
 
		      	handler.open({
		        	name: '',
		        	description: '',
		        	currency: 'EUR',
		        	amount: preco_inicial,
		        	email:'',
		      	});
		      	e.preventDefault();*/ 
			
    }

 });


});

</script>

<script>

	function comprarSelo($pacote){

		if($pacote == 'pacote1'){
			$valor = '3000';
			$valor_2 = '30.00';
		}
		else if($pacote == 'pacote2'){
			$valor = '4500';
			$valor_2 = '45.00';
		}
		else{
			$valor = '20000';
			$valor_2 = '200.00';
		}

		$('#div_compra').show();
		$('#preco_inicial').val('');
		$('#preco').html('');
		$('#preco').html($valor_2);
		$('#preco_inicial').val($valor);
		$("#invoiceType1").prop("checked", true);
	}

	
</script>
@stop