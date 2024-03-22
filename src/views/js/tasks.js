

let buttons = document.querySelectorAll('.addTask');
buttons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        // Ваш обработчик события и код здесь
        let modal = document.getElementById('myModal');

        // <input id="modal_board_id">
        //         <input id="modal_owner_id">
        //         <input id="modal_owner_id">

        console.log(button.parentElement.id);
        let modal_board_id = document.getElementById("modal_board_id");
        let modal_owner_id = document.getElementById("modal_owner_id");
        //let modal_worker_id = document.getElementById("modal_worker_id");

        modal_board_id.value = event.target.id;
        modal_owner_id.value = localStorage.getItem("uid");


        var myModal = new bootstrap.Modal(modal);

// Отобразите модальное окно
        myModal.show();
    });
});

let saveTask = document.getElementById("saveTask");

saveTask.addEventListener("click", ()=>{
    let form = document.getElementById('newTaskForm');

    let formData = new FormData(form);

    // let name = document.getElementById("title").value;
    // let description = document.getElementById("description").value;
    // let modal_board_id = document.getElementById("modal_board_id").value;
    // let modal_owner_id = document.getElementById("modal_owner_id").value;
    // let date = document.getElementById("date").value;
    // let worker = document.getElementById("worker").value;
    // let stat = document.getElementById("status").value;
    // console.log(date);
    // console.log(worker);
    // let resp = JSON.stringify({
    //     "type":"newTask",
    //     "name": name,
    //     "description": description,
    //     "kanban_id": modal_board_id,
    //     "owner_id":modal_owner_id,
    //     "worker_id": worker,
    //     "date":date,
    //     "status": stat
    // });



    fetch('/tasks/newTasks',{
        method: 'POST',
        body: formData,

    })

        .then(response=>response.text())

        .then(data=>{


            console.log(data);


            ShowNotify("Менеджер задач", "Сохраняем и обновляем", 'success');
            //
            // setTimeout(function() {
            //     // Перезагрузить текущую страницу
            //     location.reload();
            // }, 500);






        })
        .catch(error=>{
            console.log(error);
        })


});

var saveButton = document.querySelector('#myModal .btn-primary');

// Добавьте обработчик события на кнопку "Сохранить"
saveButton.addEventListener('click', function() {
    // Выполните здесь дополнительные действия, если необходимо
    ShowNotify("Менеджер задач", "Создаем новую задачу");

});