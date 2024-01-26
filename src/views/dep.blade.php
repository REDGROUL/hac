@include("header")


<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Добавление отдела</h5>
                    <input type="text" class="form-control" placeholder="Название" id="name" aria-label="Username">
                    <br>
                    <button type="button" class="btn btn-primary " id="addDep">Добавить</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Текущие</h5>
                    @foreach($deps as $dep)

                        <div class="card comment_card" id="{{$dep['id']}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <input hidden id="boardName_{{$dep['id']}}" value="{{$dep['name']}}">
                                        Название: {{$dep['name']}}
                                    </div>
                                </div>

                            </div>
{{--                            <button type="button" class="btn btn-primary del" id="delete">Удалить</button>--}}
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
<script>

    let add = document.getElementById("addDep");

    add.addEventListener('click', ()=>{
        let name = document.getElementById("name").value;

        let resp = JSON.stringify({
            "name": name});
        ShowNotify('Менеджер отделов', 'Создаем отдел')
        fetch('/addDep',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{


                console.log(data);


                if(data.status = "ok") {
                    ShowNotify('Менеджер отделов', 'Отдел "'+name + '" создан', 'success');
                }

                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);


            })
            .catch(error=>{
                console.log(error);
                ShowNotify('Менеджер отделов', error, 'danger')

            })
    })

</script>

@include("footer")


