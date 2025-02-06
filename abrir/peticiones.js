const cservicio = document.getElementById('servicio')/*funcion para dependencia servicio y subsistema*/
cservicio.addEventListener('change', sub_sistema)

const csub_sistema = document.getElementById('sub_sistema')/*funcion para dependencia de subsistema y equipo*/
csub_sistema.addEventListener('change', equipo)

const cequipo = document.getElementById('equipo')


function fetchAdnSetData(url, formData, targetElement){ 
    /*funcion que realiza las peticiones y llena los elementos con la informacion solicitada */
    return fetch(url, {
        method: "POST",
        body: formData,
        mode: 'cors'
    })
    .then(response => response.json())
    .then(data => {
        targetElement.innerHTML = data
    })
    .catch(err => console.log(err))
}

function sub_sistema(){
    let servicio = cservicio.value
    let url = 'sub_sistema.php'
    let formData = new FormData()
    formData.append('id_servicio', servicio)

    fetchAdnSetData(url, formData, csub_sistema)
}

function equipo(){
    let sub_sistema = csub_sistema.value
    let url = 'equipo.php'
    let formData = new FormData()
    formData.append('id_subsistema', sub_sistema)

    fetchAdnSetData(url, formData, cequipo)

}