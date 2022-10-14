@extends('master')
@section('main')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    



        <h2>Options</h2>
        <div class="table-responsive">
            <form action="" method="get">
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
            @if (request()->_token != null)
                <a href="{{route('dashboard')}}" class="btn btn-danger" style="margin-top: 5px">Clear</a>
            @endif
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
                    @foreach ($results as $key=>$result)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$result->user->name}}</td>
                        <td>{{$result->keyword}}</td>
                        <td>{{$result->date}}</td>
                        <td>{{$result->result}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </main>
@endsection
