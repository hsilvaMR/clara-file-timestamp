<!--<input type="hidden" id="nome" name="nome" value="timestamp-{ {$name_file}}.pdf">-->
<?php

// Include the main TCPDF library (search for installation path).

echo $name_file;
require_once(base_path('public_html/vendor/tcpdf/tcpdf.php'));

require_once(base_path('public_html/vendor/tcpdf/class_tcpdf.blade.php'));




//$pdf->Output('e.pdf', 'D');

 

//============================================================+
// END OF FILE
//============================================================+

?>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script type="text/javascript">
	


	myFunction();    

	  
	// Function returns the product of a and b 
	function myFunction() { 
		var nome  = $('#nome').val();
		console.log('nome:' + nome);
	    $.ajax({
			type: "POST",
		  	url: '{ { route('sendSelo') }}',
		  	data: { nome:nome},
		  	headers:{ 'X-CSRF-Token':'{ !! csrf_token() !!}' }
		})
		.done(function(resposta) {
			console.log(resposta);

			resp = $.parseJSON(resposta);
	        if(resp.estado=='sucesso'){          
	          	//window.location.href = resp.ref;
	        	window.location.replace(resp.ref);
	        
	        }
		});            
	} 
</script>-->