@include('header')

<style>


    .cursor-grab {
        cursor: -webkit-grab;
        cursor: grab;
    }

    .tasks {
        min-height: 450px;
    }
    </style>
<div class="container py-5">

    
    <div class="row">
@foreach($boards as $board)

        <!-- Start lane -->
        <div class="col-12 col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h5 mb-1">
                        {{$board['name']}}
                    </h3>
                    <small class="mb-0 text-muted">
                        {{$board['description']}}
                    </small>
                </div>
                <div class="card-body">
                    <div class="tasks" id="{{$board['id']}}">
                        <!-- Start task -->

                        @foreach($tasks as $task)
                            @if($task['kanban_id'] == $board['id'])

                                <div class="card mb-3 cursor-grab" id="{{$task['id']}}">
                                    <div class="card-body">

                                        <p class="mb-0">{{$task['name']}}</p>
                                        <div class="text-right">
                                            <small class="text-muted mb-1 d-inline-block">25%</small>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    @endforeach
                        <!-- End task -->
{{--                        <!-- Start task -->--}}
{{--                        <div class="card mb-3 cursor-grab">--}}
{{--                            <img class="card-img-top" src="https://source.unsplash.com/sECcwm6BN8w/400x200" alt="Bootstrap Kanban Board" />--}}
{{--                            <div class="card-body">--}}
{{--                                <span class="badge bg-primary text-white mb-2">On hold</span>--}}
{{--                                <p class="mb-0">Moving them anywhere else isn't quite possible</p>--}}
{{--                                <div class="text-right">--}}
{{--                                    <small class="text-muted mb-1 d-inline-block">33%</small>--}}
{{--                                </div>--}}
{{--                                <div class="progress" style="height: 5px;">--}}
{{--                                    <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- End task -->
                    </div>
                    <div class="btn btn-primary btn-block">Add task</div>
                </div>
            </div>
        </div>
    @endforeach



    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Менеджер задач</strong>
            <small>Только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Изменение статуса задачи прошло успешно!
        </div>
    </div>
</div>


<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js'></script>
<script>
    {{--dragula([--}}
    {{--    // document.querySelector('#backlog'),--}}
    {{--    // document.querySelector('#progress'),--}}
    {{--    // document.querySelector('#completed')--}}

    {{--    @foreach($boards as $board)--}}
    {{--        document.querySelector('#{{$board["name"]}}'),--}}
    {{--    @endforeach--}}


    {{--    // drake.on('drag', (el, source) => {--}}
    {{--    //     // `el` - перетаскиваемый элемент--}}
    {{--    //     // `source` - исходный контейнер, из которого происходит перетаскивание--}}
    {{--    //     const parentBlock = source; // Родительский блок можно получить из `source`--}}
    {{--    //     console.log('Родительский блок:', parentBlock);--}}
    {{--    // })--}}
    {{--],{--}}
    {{--    drake.on('drag', (el, source) => {--}}
    {{--        // `el` - перетаскиваемый элемент--}}
    {{--        // `source` - исходный контейнер, из которого происходит перетаскивание--}}
    {{--        const parentBlock = source; // Родительский блок можно получить из `source`--}}
    {{--        console.log('Родительский блок:', parentBlock);--}}
    {{--    })--}}
    {{--});--}}


    dragula([
        @foreach($boards as $board)
        document.getElementById('{{$board["id"]}}'),
        @endforeach]).on('drag', function (el) {
        el.className = el.className.replace('ex-moved', '');
    }).on('drop', function (el) {
        el.className += ' ex-moved';


        console.log(el.id);
        console.log(el.parentElement.id);

        let resp = JSON.stringify({
            "type":"changeStatus",
            "taskId": el.id,
            "kanban_id": el.parentElement.id});

        fetch('http://hac2/tasks/changeStatus',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.text())

            .then(data=>{


                console.log(data);



                var myToast = new bootstrap.Toast(document.getElementById('liveToast'));

                // Покажите уведомление
                myToast.show();

            })
            .catch(error=>{
                console.log(error);
            })
    });
</script>
@include('footer')