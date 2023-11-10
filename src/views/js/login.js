let loginbtn = document.getElementById('login');

loginbtn.addEventListener("click", (e)=> {
    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    const login = document.getElementById('loginUsername').value;
    const pass = document.getElementById('loginPassword').value;

    let resp = JSON.stringify({
        "type":"auth",
        "login": login,
        "pass": pass});

    fetch('http://hac2/login',{
        method: 'POST',
        body: resp
    })
        .then(response=>response.text())

        .then(data=>{
            console.log(data);
        })
        .catch(error=>{
            console.log(error);
        })


})