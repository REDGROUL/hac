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
                                        <input hidden id="boardName_{{$board['id']}}" value="{{$board['name']}}">
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
        ShowNotify('Менеджер досок', 'Добавляем новую доску')
        fetch('/addBoard',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{


                console.log(data);


                if(data.status = "saved") {
                    ShowNotify('Менеджер досок', 'Доска "'+data.name + '" добавлена', 'success');
                }

                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);


            })
            .catch(error=>{
                console.log(error);
                ShowNotify('Менеджер досок', error, 'danger')

            })
    })

    let buttons = document.querySelectorAll('.del');

    buttons.forEach(elem =>{
        elem.addEventListener('click', ()=>{
            let id = elem.parentElement.id
            console.log(id);
            let name = document.getElementById("boardName_"+id).value;
            let descr = document.getElementById("name").value;
            let resp = JSON.stringify({
                "type":"delete",
                "id": id});
            ShowNotify('Менеджер досок', 'Удаляем доску "'+name+'"', 'warning')
            fetch('/delboard',{
                method: 'POST',
                body: resp,

            })

                .then(response=>response.json())

                .then(data=>{


                    console.log(data);



                    ShowNotify('Менеджер досок', 'Доска "'+name+'" удалена', 'success')
                    setTimeout(function() {
                        // Перезагрузить текущую страницу
                        location.reload();
                    }, 500);


                })
                .catch(error=>{


                    ShowNotify('Менеджер досок', 'На доске "'+name+'" есть задачи, такую доску удалить нельзя', 'danger')
                })
        })
    })


    </script>


@include('footer')
