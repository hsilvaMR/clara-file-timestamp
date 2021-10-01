@extends('layouts/time/default')

@section('content')



<center> 
		<div>
			<span id="clockT" style="font-size:13px;font-variant:small-caps;font-weight:bold;color:NavyBlue;"></span> 
			<br><br>
			<span id="clock0" style="color:#000000;font-size:16px;font-variant:small-caps;font-weight:bold;"></span> 
		</div> 
	</center> 


@stop


@section('css')
@stop


@section('javascript')
<script type="text/javascript" src="http://www.oal.ul.pt/HoraLegalOAL/HoraLegalOAL.js"></script> 





<script language="javascript">
	window.onload=function(){ setTimeout("HoraLegalOAL.jsClockGMT()",500); } 

	setTimeout(function() {
  		var hora = $('#clock0').text();

	}, 550);

	
</script>


@stop


