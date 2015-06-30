$(document).ready(function(){
    /*TESTEMUNHOS ADD*/
    $('textarea').keydown(function(e) {
        var tval = $('textarea').val(),
            tlength = tval.length,
            set = 4500,
            remain = parseInt(set - tlength);

        if (remain <= 0 && e.which !== 8) {
            $('textarea').val((tval).substring(0, 4500));
            remain=0;
        }
        $('#characters span').text(remain);

    }).keyup(function(e) {
            var tval = $('textarea').val(),
                tlength = tval.length,
                set = 4500,
                remain = parseInt(set - tlength);
            if (remain <= 0 && e.which !== 8) {
                $('textarea').val((tval).substring(0, 4500));
                remain=0;
            }
            $('#characters span').text(remain);
        });

    //CALL MORE OPTIONS CHANGING THE SELECTIONS
    $("select").change(function(){
        var selectionValue = $(this).find("option:selected").val();
        var id = $(this).attr("id");

        switch (id){
            case "ano":
                $("#mes").empty();
                $("#dia").empty();

                $("#mes").append('<option value="0">Selecione o m&ecirc;s</option>');
                $("#dia").append('<option value="0">Selecione o dia</option>');

                $('#mes').prop('disabled', 'disabled');
                $('#dia').prop('disabled', 'disabled');

                if (selectionValue>0){
                    $.fancybox.showLoading();

                    $.ajax({
                        url: 'includes/requests/data.php',
                        type:"POST",
                        dataType: 'json',
                        data:{ type: "mes",sel: selectionValue},
                        success: function(data){
                            $("#mes").append(data);
                            $.fancybox.hideLoading();
                            $('#mes').prop('disabled', false);
                        }
                    });
                }

                break;
            case "mes":

                $("#dia").empty();

                $("#dia").append('<option value="0">Selecione o dia</option>');

                $('#dia').prop('disabled', 'disabled');

                if (selectionValue>0){
                    $.fancybox.showLoading();

                    $.ajax({
                        url: 'includes/requests/data.php',
                        type:"POST",
                        dataType: 'json',
                        data:{ type: "dia",sel: selectionValue,ano: $("#ano").val()},
                        success: function(data){
                            $("#dia").append(data);
                            $.fancybox.hideLoading();
                            $('#dia').prop('disabled', false);
                        }
                    });
                }

                break;
        }
    });

    /*FORM VALIDATION*/
    var errors=[];
    $("#testemunhos input, #testemunhos textarea").blur(function(){
        validateForm("element",$(this));
    });

    $("#testemunhos #freguesias,#testemunhos #ano ,#testemunhos #mes ,#testemunhos #dia").change(function(){
        validateForm("element",$(this));
    });


    function validateForm(action,element){
        var value="";
        switch(action){
            case "all":
                //CHECK NAME
                value=$("#name").val();
                if (value=="" || $.trim(value).length==0){
                    $("#name").addClass("error");
                    errors.push("true");
                    if ($("#nameError").length==0){
                        $("#name").after("<span id=\"nameError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else{
                    $("#name").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }
                    if ($("#nameError").length!=0)
                        $("#nameError").remove();
                }

                //CHECK SURNAME
                value=$("#surname").val();
                if (value=="" || $.trim(value).length==0){
                    $("#surname").addClass("error");
                    errors.push("true");
                    if ($("#surnameError").length==0){
                        $("#surname").after("<span id=\"surnameError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else{
                    $("#surname").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }
                    if ($("#surnameError").length!=0)
                        $("#surnameError").remove();
                }

                //CHECK DATE
                value=$("#ano").val();
                if (value=="" || $.trim(value).length==0 || value==0){
                    $("#ano").addClass("error");
                    errors.push("true");
                    if ($("#anoError").length==0){
                        $("#dia").after("<span id=\"anoError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else if ($("#mes").val()=="" || $.trim($("#mes").val()).length==0 || $("#mes").val()==0){
                    value=$("#mes").val();
                    $("#mes").addClass("error");
                    errors.push("true");
                    if ($("#mesError").length==0){
                        $("#dia").after("<span id=\"mesError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }

                }else if ($("#dia").val()=="" || $.trim($("#dia").val()).length==0 || $("#dia").val()==0){
                    value=$("#dia").val();
                    $("#dia").addClass("error");
                    errors.push("true");
                    if ($("#diaError").length==0){
                        $("#dia").after("<span id=\"diaError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }

                }else{
                    $("#ano").removeClass("error");
                    $("#mes").removeClass("error");
                    $("#dia").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }

                    if ($("#anoError").length!=0)
                        $("#anoError").remove();
                    if ($("#mesError").length!=0)
                        $("#mesError").remove();
                    if ($("#diaError").length!=0)
                        $("#diaError").remove();
                }

                //CHECK CONTACT
                value=$("#contact").val();
                if (value=="" || $.trim(value).length==0){
                    $("#contact").addClass("error");
                    errors.push("true");
                    if ($("#contactError").length==0){
                        $("#contact").after("<span id=\"contactError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else{
                    $("#contact").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }
                    if ($("#contactError").length!=0)
                        $("#contactError").remove();
                }

                //CHECK FREGUESIAS
                value=$("#freguesias").val();
                if (value=="" || $.trim(value).length==0 || value==0){
                    $("#freguesias").addClass("error");
                    errors.push("true");
                    if ($("#freguesiasError").length==0){
                        $("#freguesias").after("<span id=\"freguesiasError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else{
                    $("#freguesias").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }
                    if ($("#freguesiasError").length!=0)
                        $("#freguesiasError").remove();
                }

                //CHECK TESTEMUNHO
                value=$("#testemunhoTXT").val();
                if (value=="" || $.trim(value).length==0){
                    $("#testemunhoTXT").addClass("error");
                    errors.push("true");
                    if ($("#testemunhoTXTError").length==0){
                        $("#characters").after("<span id=\"testemunhoTXTError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                    }
                }else{
                    $("#testemunhoTXT").removeClass("error");
                    if (errors.length>=1){
                        errors.splice((errors.length-1),1);
                    }
                    if ($("#testemunhoTXTError").length!=0)
                        $("#testemunhoTXTError").remove();
                }

                break;
            case "element":
                //CHECK NAME
                if (element.attr("name")=="name"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#nameError").length==0){
                            element.after("<span id=\"nameError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#nameError").length!=0)
                            $("#nameError").remove();

                    }

                //CHECK SURNAME
                }else if (element.attr("name")=="surname"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#surnameError").length==0){
                            element.after("<span id=\"surnameError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#surnameError").length!=0)
                            $("#surnameError").remove();

                    }

                //CHECK FREGUESIAS
                }else if (element.attr("name")=="freguesias"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0 || value==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#freguesiasError").length==0){
                            element.after("<span id=\"freguesiasError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#freguesiasError").length!=0)
                            $("#freguesiasError").remove();

                    }

                //CHECK ANO
                }else if (element.attr("name")=="ano"){
                    //clear others errors
                    if ($("#mesError").length!=0)
                        $("#mesError").remove();
                    $("#mes").removeClass("error");

                    //startcheck
                    value=element.val();
                    if (value=="" || $.trim(value).length==0 || value==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#anoError").length==0){
                            $("#dia").after("<span id=\"anoError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#anoError").length!=0)
                            $("#anoError").remove();

                    }

                //CHECK MES
                }else if (element.attr("name")=="mes"){
                    //clear others errors
                    if ($("#diaError").length!=0)
                        $("#diaError").remove();
                    $("#dia").removeClass("error");

                    //start check
                    value=element.val();
                    if (value=="" || $.trim(value).length==0 || value==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#mesError").length==0){
                            $("#dia").after("<span id=\"mesError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#mesError").length!=0)
                            $("#mesError").remove();

                    }

                //CHECK DIA
                }else if (element.attr("name")=="dia"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0 || value==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#diaError").length==0){
                            element.after("<span id=\"diaError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#diaError").length!=0)
                            $("#diaError").remove();

                    }

                //CHECK CONTACT
                }else if (element.attr("name")=="contact"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#contactError").length==0){
                            element.after("<span id=\"contactError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#contactError").length!=0)
                            $("#contactError").remove();

                    }

                //CHECK TESTEMUNHO
                }else if (element.attr("name")=="testemunhoTXT"){
                    value=element.val();
                    if (value=="" || $.trim(value).length==0){
                        element.addClass("error");
                        errors.push("true");
                        if ($("#testemunhoTXTError").length==0){
                            $("#characters").after("<span id=\"testemunhoTXTError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>")
                        }
                    }else{
                        element.removeClass("error");
                        if (errors.length>=1){
                            errors.splice((errors.length-1),1);
                        }
                        if ($("#testemunhoTXTError").length!=0)
                            $("#testemunhoTXTError").remove();
                    }
                }
                break;
        }

    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

    //SUBMIT VALIDATION
    $("#submeter").click(function(){
        validateForm("all",0);

        if (errors.length>=1){
            return false;

        //PHP VALIDATION
        }else{
            var nome = $("#name").val(),
                sobrenome = $("#surname").val(),
                contacto = $("#contact").val(),
                freguesia = $("#freguesias").val(),
                testemunho = $("#testemunhoTXT").val(),
                ano = $("#ano").val(),
                mes = $("#mes").val(),
                dia = $("#dia").val(),
                status = 1;


            //CHECK DATE
            if (ano==0){
                    $("#ano").addClass("error");
                    if ($("#anoError").length==0)
                    $("#dia").after("<span id=\"anoError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>");
            }else if(mes==0){
                    $("#mes").addClass("error");
                    if ($("#mesError").length==0)
                    $("#dia").after("<span id=\"mesError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>");
            }else if(dia==0){
                    $("#dia").addClass("error");
                    if($("#diaError").length==0)
                    $("#dia").after("<span id=\"diaError\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>");

            //IF DATE IS "OK"
            }else{

                //CHECK WITH PHP
                $.fancybox.showLoading();
                $.ajax({
                    url: 'includes/requests/validateForm.php',
                    type:"POST",
                    dataType: 'json',
                    data:{ checkData: true, nome: nome, sobrenome: sobrenome, contacto: contacto, freguesia: freguesia, testemunho: testemunho,ano: ano, mes: mes, dia: dia, status: status},
                    success: function(errorData){
                        //console.log(errorData);

                        //CLEAN ERRORS
                        if ($("#nameError").length!=0)
                            $("#nameError").remove();
                        if ($("#surnameError").length!=0)
                            $("#surnameError").remove();
                        if ($("#contactError").length!=0)
                            $("#contactError").remove();
                        if ($("#freguesiasError").length!=0)
                            $("#freguesiasError").remove();
                        if ($("#testemunhoTXTError").length!=0)
                            $("#testemunhoTXTError").remove();


                        if (errorData.length>=1){
                            $.each(errorData, function(key, value) {
                                if (value=="contact"){
                                    $("#"+value).addClass("error");
                                    $("#"+value).after("<span id=\""+value+"Error\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">E-mail inserido não é válido</span>");
                                }else if (value=="testemunhoTXT"){
                                    $("#"+value).addClass("error");
                                    $("#characters").after("<span id=\""+value+"Error\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>");
                                }else{
                                    $("#"+value).addClass("error");
                                    $("#"+value).after("<span id=\""+value+"Error\" style=\"font-size:12px;color:red;height:12px;margin:-15px 0 3px 0;display:block;\">Este campo é de preenchimento obrigatório</span>");
                                }

                            });
                            $.fancybox.hideLoading();

                        }else{

                            //console.log("Sucesso");
                            $(".statusMessage").css("display","block");
                            $(".fancybox-wrap").fadeOut(200);
                            $(".statusMessage, .fancybox-overlay").delay(5000).fadeOut(500,function(){
                                $(".statusMessage").css("display","none");
                                $.fancybox.hideLoading();
                                window.location = "emocoes";

                            });
                        }
                    }
                });
            }
            return false;
        }
    });


    /*END FORM VALIDATION*/
});