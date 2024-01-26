

let loginbtn = document.getElementById('login');
loginbtn.addEventListener("click", ()=> {
    const form = document.getElementById('loginForm');
    const login = document.getElementById('loginUsername').value;
    const pass = document.getElementById('loginPassword').value;
    console.log("click")
    let resp = JSON.stringify({
        "type":"auth",
        "login": login,
        "pass": pass});
    ShowNotify("Менеджер авторизации", "Отправляем данные для проверки");
    fetch('/login',{
        method: 'POST',
        body: resp,

    })

        .then(response=>response.json())

        .then(data=>{
            if(data.status == "ok") {
                localStorage.setItem('access', data['access']);
                localStorage.setItem('refresh', data['refresh']);
                ShowNotify("Менеджер авторизации", "Успешая авторизация! \n " +
                    "Переводим на страницу задач", "success");
                window.location ='/tasks';
            } else {
                ShowNotify("Ошибка", "Пользователь не найден!", 'warning');
            }

        })
        .catch(error=>{
            console.log(error);
            ShowNotify("Ошибка", error, 'alert');
        })

})