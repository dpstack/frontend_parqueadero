/* Here comes the Javascript code */

// Update the REST API server's URL
const url = "http://127.0.0.1:8000/api/";

// List of records loaded from API REST
var records = [];

// Login modal dialog
const loginDialog = new bootstrap.Modal('#login-dialog', {
    focus: true
});

/**
 * Execute as soon as the page is completely loaded.
 */

window.onload = function () {
    // Set the listeners for the page's buttons

    const bLogin = document.getElementById("bLogin");
    const bLoginAccept = document.getElementById("blogin-accept");
    const bAparcar = document.getElementById("bAparcar");
    const bClear = document.getElementById("bClear");
    const bDesaparcar = document.getElementById("bDesaparcar");
    // const bReload = document.getElementById("bReload");

    // bLogin.addEventListener("click", handleLogin);
    bLoginAccept.addEventListener("click", handleLogin);
    bAparcar.addEventListener("click", addRecord);
    bClear.addEventListener("click", clearForm);
    bDesaparcar.addEventListener("click", deleteRecord);
    // bReload.addEventListener("click", reloadList);
};

/**
 * Clear the fields of the product's form.
 */

function clearForm() {
    const tfParking = document.getElementById("parking");
    const tfParkingPlace = document.getElementById("parking_place");
    const tfVehicle = document.getElementById("vehicle");

    tfParking.value = "";
    tfParkingPlace.value = "";
    tfVehicle.value = "";

}

/**
 * Handle the login/logout magic: 
 * 
 *  - Show the login dialog
 *  - Call the login procedure
 *  - Call the logout procedure
 * 
 * @param {*} event 
 */

function handleLogin(event) {
    var flag = event.target.innerText;

    if (flag == "Login") {  // Show the login dialog
        loginDialog.show();
    } else if (flag == "Accept") {  // Login the user (get new token)
        login();
        document.getElementById("bLogin").innerText = "Logout";
        loginDialog.hide();
    } else if (flag == "Logout") {  // Logout the user (release token)
        logout();
        document.getElementById("bLogin").innerText = "Login";
    } else {    // Error, the flag has unknown value
        alert("ERROR: flag type unknown: " + flag);
    }
}

/**
 * Login the user.
 */

async function login() {
    var valorEmail = document.getElementById("login_email").value;
    var valorPassword = document.getElementById("login_password").value;

    const params = {
        email: valorEmail,
        password: valorPassword
    }

    const response = await fetch(url + 'login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(params)
    });

    const answer = await response.json();

    //var token = answer.token;

    if (response.status == 200) {
        localStorage.setItem('token', answer.token);
        console.log("Sesion iniciada correctamente");
    } else {
        alert("Error loging in: " + response.statusText);
    }
}

/**
 * Logout the user.
 */

async function logout() {
    // Here comes the code ...
    const response = await fetch(url + "logout", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer' + localStorage.getItem('token')
        },

    });

    if (response.status == 200) {
        localStorage.removeItem('token');
        console.log("Ok");
    }
    else {
        alert("Error logging out: " + response.statusText);
    }
}

/**
 * Create a new product.
 */

/**
 * Load the list of products.
 */

async function addRecord() {
    const tlugarparqueo = document.getElementById("idParqueo").value;
    const tfhora_ingreso = document.getElementById("hora_ingreso").value;
    const tfhora_egreso = document.getElementById("hora_egreso").value;
    const tfdia = document.getElementById("dia_vehiculo").value;
    const tftipoVehiculo_id = document.getElementById("Tipovehicle_id").value;
    const tfUser_id = document.getElementById("user_id").value;

    const params = {

        hora_ingreso: tfhora_ingreso,
        hora_egreso: tfhora_egreso,
        dia: tfdia,
        tipoVehiculo_id: tftipoVehiculo_id,
        user_id: tfUser_id,

    }

    const response = await fetch(url + 'setVehiculo/' + tlugarparqueo, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // 'Authorization': 'Bearer' + localStorage.getItem('token')
        },
        body: JSON.stringify(params)
    });

    const answer = await response.json();
    console.log(params.tipoUser_id);
    console.log("🚀 ~ addRecord ~ answer", answer);

    if (response.status === 200)
        alert("Vehiculo aparcado: " + answer.id);
    else
        alert("No fue posible aparcar el vehiculo: " + answer.message);
}

/**
 * Load the data of a product.
 * 
 * @param {*} id 
 */

function loadListItem(id) {
    // Here comes the code ...
}

/**
 * Delete a product.
 */

async function deleteRecord() {
    const tlugarparqueo = document.getElementById("idParqueo").value;

    const response = await fetch(url + 'removeVehiculo/' + tlugarparqueo, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // 'Authorization': 'Bearer' + localStorage.getItem('token')
        },
    });

    const answer = await response.json();
    console.log("🚀 ~ addRecord ~ answer", answer);

    if (response.status === 200)
        alert("Vehiculo Desaparcado Exitosamente!! ");
    else
        alert("No fue posible aparcar el vehiculo: " + answer.message);

}

/**
 * Create a new product.
 */


/**
 * Load the list of products.
 */