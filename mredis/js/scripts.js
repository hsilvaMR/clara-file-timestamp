//var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')

//    formData = new FormData(),
//    formData.append('file', myFile);

//alert("size: " + myFile.size  + " name: "  + myFile.name  +  " type: " +  myFile.type  )

// ler e validar o ficheiro 
$('#fileUploadCliente').on('change', function(e) {

    var myFile = this.files[0];

    formData = new FormData(),
        formData.append('file', myFile);

    if (myFile.size > 0) {

        $.ajax({
            type: "POST",
            url: "script",
            data: formData,
            ache: false,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response == "sucess") {

                    alert("send file")
                } else {

                    alert("error file")

                }
            },
            error: function(response) {
                console.log("error : " + response)
            },

        })

        //alert("size: " + myFile.size  + " name: "  + myFile.name  +  " type: " +  myFile.type  )

    } else {

        alert("ficheiro invalido ")
        console.log("error : " + response)

    }

});