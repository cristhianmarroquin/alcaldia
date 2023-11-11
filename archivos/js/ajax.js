const formularios_ajax=document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e){
    e.preventDefault();
    var estado = document.getElementById('estado').value; 
    let enviar;
    if (estado == "buscar") {
        enviar=true;
    }else{
        enviar=confirm("Quieres "+estado+" el formulario");
    }
    if(enviar==true){

        let data= new FormData(this);
        let method=this.getAttribute("method");
        let action=this.getAttribute("action");

        let encabezados= new Headers();

        let config={
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };
        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{ 
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        });
    }

}

function img_carga() {
    const fileName = document.querySelector('#file-js-example .file-name');
    const fileInput = document.querySelector('#file-js-example input[type=file]');
    if (fileInput.files.length > 0) {
        fileName.textContent = fileInput.files[0].name;
        document.getElementById("img_carga").src="./img/carga-en-la-nube (1).png";
    }else{
        document.getElementById("img_carga").src="./img/carga-en-la-nube (2).png";
        fileName.textContent = "No se selecciono ningun archivo";
    }
}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",enviar_formulario_ajax);
});