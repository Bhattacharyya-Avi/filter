@extends('master')
@section('main')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    



        <h2>Options</h2>
        <div class="table-responsive">
            <form action="{{route('search.filter')}}" method="get">
            {{-- <form action="{{route('search.list')}}" method="get"> --}}
                @csrf
                <h6>users</h6>
                @foreach ($users as $key=>$user)
                <div class="form-check form-check-inline">
                    <input name="user" class="form-check-input" type="checkbox" id="inlineCheckbox1"
                        value="{{$user->id}}">
                    <label class="form-check-label" for="inlineCheckbox1">{{$user->name}}</label>
                </div>
                @endforeach

                <h6>Keywords</h6>
                @foreach ($keywords_list as $key=>$keyword_list)
                <div class="form-check form-check-inline">
                    <input name="keyword" class="form-check-input" type="checkbox"
                        id="inlineCheckbox1{{$key+1}}" value="{{$keyword_list->keyword}}">
                    <label class="form-check-label" for="inlineCheckbox1">{{$keyword_list->keyword}}
                        {{$keyword_list->total}} Times</label>
                </div>
                @endforeach

                <h6>Time</h6>
                <div class="form-check form-check-inline">
                    <input name="time" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Yesterday">
                    <label class="form-check-label" for="inlineCheckbox1">Yesterday</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="time" class="form-check-input" type="checkbox" id="inlineCheckbox2" value="LastWeek">
                    <label class="form-check-label" for="inlineCheckbox1">Last week</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="time" class="form-check-input" type="checkbox" id="inlineCheckbox2" value="LastMonth">
                    <label class="form-check-label" for="inlineCheckbox1">Last month</label>
                </div>

                <h6>Date range</h6>
                <div class="row">
                    <div class="col">
                        <label for="fromdate">From Date</label>
                        <input name="fromdate" type="date" class="form-control" placeholder="">
                    </div>
                    <div class="col">
                        <label for="totdate">To Date</label>
                        <input name="todate" type="date" class="form-control" placeholder="">
                    </div>
                </div>
                <br>
                <div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div> 
            </form>
        </div>
        <br>
        
        <h2>Results table</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User name</th>
                        <th scope="col">keyword</th>
                        <th scope="col">date</th>
                        <th scope="col">Result</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td>1</td>
                        <td>username</td>
                        <td>keyword</td>
                        <td>date</td>
                        <td>result</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </main>
@endsection

@section('ajax')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })

        // reading all data
        function readdata(){
            $.ajax({
                type:"GET",
                dataType:'json',
                url: "{{route('search.list')}}",
                success:function(search_result) {
                    var data = ""
                    // data.empty();
                    $.each(search_result, function(key,value) {
                        // console.log(value)
                        data = data + "<tr>"
                        data = data + "<td>"+(key+1)+"</td>"
                        data = data + "<td>"+value.user.name+"</td>"
                        data = data + "<td>"+value.keyword+"</td>"
                        data = data + "<td>"+value.date+"</td>"
                        data = data + "<td>"+value.result+"</td>"
                        data = data + "</tr>"
                    })
                    $('tbody').html(data);
                }
            })
        }
        readdata();

        function resultdata(){
            $.ajax({
                type:"get",
                dataType:'json',
                url: "{{route('search.filter')}}",
                success:function(filter_result) {
                    var data = ""
                    $.each(filter_result, function(key,value) {
                        console.log(value)
                        data = data + "<tr>"
                        data = data + "<td>"+(key+1)+"</td>"
                        data = data + "<td>"+value.user.name+"</td>"
                        data = data + "<td>"+value.keyword+"</td>"
                        data = data + "<td>"+value.date+"</td>"
                        data = data + "<td>"+value.result+"</td>"
                        data = data + "</tr>"
                    })
                    $('tbody').html(data);
                }
            })
        }
        resultdata()

    </script>
@endsection
