

document.addEventListener("DOMContentLoaded", function(event) {
    let loginbtn = document.getElementById('login');
    loginbtn.addEventListener("click", (e)=> {
        const form = document.getElementById('loginForm');

        const login = document.getElementById('loginUsername').value;
        const pass = document.getElementById('loginPassword').value;



        let resp = JSON.stringify({
            "type":"auth",
            "login": login,
            "pass": pass});

        fetch('/login',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{

                localStorage.setItem('access', data['access']);
                localStorage.setItem('refresh', data['refresh']);

                window.location ='/tasks';
            })
            .catch(error=>{
                console.log(error);
            })




    })
});




function f() {


}