function select(tipo) {
    if (tipo == "dependencia") {
        $("#sel_ser").empty();
        $("#sel_subser").empty();
        ocultar_tipo();
        var parametro =  document.getElementById("sel_depen").value;
    }else if (tipo == "serie") {
        $("#sel_subser").empty();
        ocultar_tipo();
        var parametro =  document.getElementById("sel_ser").value;
    }else if (tipo == "tipo") {
        ocultar_tipo();
        var parametro =  document.getElementById("sel_subser").value;
    }
    
    $.ajax({
        url: "./php/documento/ajax/select.php",
        type: 'GET',
        data: {parametro:parametro,tipo:tipo},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                if (tipo == "dependencia") {
                    $("#sel_subser").append("<option value=' '>Selecciona un SubSerial</option>"); 
                    if (id=="") {
                        $("#sel_ser").append("<option value=' '>"+name+"</option>");         
                    }else{
                        $("#sel_ser").append("<option value='"+id+"'>"+id+" - "+name+"</option>");
                    }
                }else if (tipo == "serie") {
                    if (id=="") {
                        $("#sel_subser").append("<option value=' '>"+name+"</option>");                    
                    }else{
                        $("#sel_subser").append("<option value='"+id+"'>"+id+" - "+name+"</option>");
                    }
                }else if (tipo == "tipo") {
                    document.getElementById("tipo"+i).style.display = 'block';
                    document.getElementById("tipo"+i).textContent = name; 
                }
            }
        }
    });
}

function ocultar_tipo() {
    document.getElementById('tipo0').style.display = 'none';
    document.getElementById("tipo1").style.display = 'none';
    document.getElementById("tipo2").style.display = 'none';
    document.getElementById("tipo3").style.display = 'none';
    document.getElementById("tipo4").style.display = 'none';
    document.getElementById("tipo5").style.display = 'none';
    document.getElementById("tipo6").style.display = 'none';
    document.getElementById("tipo7").style.display = 'none';
    document.getElementById("tipo8").style.display = 'none';
    document.getElementById("tipo9").style.display = 'none';
    document.getElementById("tipo10").style.display = 'none';
    document.getElementById("tipo11").style.display = 'none';
    document.getElementById("tipo12").style.display = 'none';
    document.getElementById("tipo13").style.display = 'none';
    document.getElementById("tipo14").style.display = 'none';
    document.getElementById("tipo15").style.display = 'none';
}