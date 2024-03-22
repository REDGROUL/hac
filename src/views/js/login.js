let loginbtn = document.getElementById('login');
loginbtn.addEventListener("click", () => {
    const login = document.getElementById('loginUsername').value;
    const pass = document.getElementById('loginPassword').value;
    console.log("click")
    let resp = JSON.stringify({
        "login": login,
        "pass": pass
    });
    ShowNotify("Менеджер авторизации", "Отправляем данные для проверки");
    fetch('/auth', {
        method: 'POST',
        body: resp,

    })

        .then(response => response.json())

        .then(data => {


            if (data.status === true) {
                console.log(data)
                localStorage.setItem("uid", data['uid'])
                ShowNotify("Менеджер авторизации", "Успешая авторизация! \n " +
                    "Переводим на страницу задач", "success");
                window.location = '/tasks';
            } else {
                console.log(data)
                ShowNotify("Ошибка", "Пользователь не найден!", 'warning');
            }

        })
        .catch(error => {
            console.log(error);
            ShowNotify("Ошибка", error, 'alert');
        })

})