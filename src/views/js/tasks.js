const dialog = document.querySelector(".example-dialog");


document.getElementById("closeDialog").addEventListener("click", ()=>{
    dialog.open = false;
})

let saveTask = document.getElementById("saveTask");

saveTask.addEventListener("click", ()=>{
    let form = document.getElementById('newTaskForm');

    let formData = new FormData(form);

    fetch('/tasks/newTasks',{
        method: 'POST',
        body: formData,

    })

        .then(response=>response.text())

        .then(data=>{


            console.log(data);

            dialog.open = false;
            ShowNotify("Менеджер задач", "Сохраняем и обновляем", 'success');

            //
            setTimeout(function() {
                // Перезагрузить текущую страницу
                location.reload();
            }, 500);






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
