@include('header')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">



                <div class="card-body">
                    <h5 class="card-title">Добавление доски:</h5>
                    <input type="text" class="form-control" placeholder="Название" id="name" aria-label="Username">
                    <br>
                    <input type="text" class="form-control" placeholder="Описание" id="description" aria-label="Username">
                    <br>
                    <button type="button" class="btn btn-primary " id="addKanban">Добавить</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Текущие</h5>
                    @foreach($boards as $board)


                        <div class="card comment_card" id="{{$board['id']}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        Название: {{$board['name']}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        Описание: {{$board['description']}}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary del" id="delete">Удалить</button>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Менеджер досок</strong>
            <small>Только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Обновляем список досок!
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="faildel" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Менеджер досок</strong>
            <small>Только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Нельзя удалить доску с задачами!
        </div>
    </div>
</div>
<script>
    let add = document.getElementById("addKanban");
    let del = document.getElementById("delete");


    add.addEventListener('click', ()=>{
        let name = document.getElementById("name").value;
        let descr = document.getElementById("description").value;
        let resp = JSON.stringify({
            "type":"addBoard",
            "name": name,
            "descr": descr});
        fetch('/addBoard',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{


                console.log(data);



                var myToast = new bootstrap.Toast(document.getElementById('liveToast'));

                // Покажите уведомление
                myToast.show();
                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);


            })
            .catch(error=>{
                console.log(error);
                var myToast = new bootstrap.Toast(document.getElementById('faildel'));

                // Покажите уведомление
                myToast.show();

            })
    })

    let buttons = document.querySelectorAll('.del');

    buttons.forEach(elem =>{
        elem.addEventListener('click', ()=>{
            let id = elem.parentElement.id
            console.log(id);
            let name = document.getElementById("name").value;
            let descr = document.getElementById("name").value;
            let resp = JSON.stringify({
                "type":"delete",
                "id": id});
            fetch('/delboard',{
                method: 'POST',
                body: resp,

            })

                .then(response=>response.json())

                .then(data=>{


                    console.log(data);



                    var myToast = new bootstrap.Toast(document.getElementById('liveToast'));

                    // Покажите уведомление
                    myToast.show();
                    setTimeout(function() {
                        // Перезагрузить текущую страницу
                        location.reload();
                    }, 500);


                })
                .catch(error=>{
                    console.log(error);
                    var myToast = new bootstrap.Toast(document.getElementById('faildel'));

                    // Покажите уведомление
                    myToast.show();
                })
        })
    })


    </script>


@include('footer')
