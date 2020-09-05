@extends('layouts.app')

@section('content')

@php
    if(Auth::user()->role == "employee") {
        $presentPercentage = "invalid";
    }
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( Auth::user()->role == 'admin' )
                <div class="card">
                    <div class="card-header">

                        <label for="employee_list">Employee List</label>
                        @if (isset($date))
                            <input style="float: right" type="date" id="attendanceDate" name="attendance_date" value="{{ date('Y-m-d', strtotime($date)) }}">
                        @endif

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(count($users) >= 1)

                            <table id="employees">
                                  <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Present</th>
                                  </tr>

                                @if(isset($users))
                                    @php $i = 1 @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            {{ $user->empDetails->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->empDetails->designation }}
                                        </td>
                                        <td>
                                            @if ( in_array($user->id, $presentUserIds, true) )
                                                Present
                                            @else
                                                Absent
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </table>

                        @endif
                    </div>
                </div>
            @else

                @if (isset($present))

                    @if ($present)
                        
                        <p>Marked as Present today.</p>

                    @else

                        <div>

                            <input type="checkbox" id="present" onclick="markPresent()">
                            <label for="present">Mark as Present</label>

                        </div>

                    @endif
                    
                @endif

            @endif
        </div>
        @if (Auth::user()->role == "admin")
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Chart</div>
                    <div class="card-body">

                        <canvas id="empChart" width="400" height="400"></canvas>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function(){

            $('#attendanceDate').change(function() {

                let date = this.value;
                let url = "{{ url('getAttendance') }}";
                document.location.href=url+'/'+date;

            });

            var presentPer = "{{$presentPercentage}}";
            if(presentPer != "invalid") {

                presentPer = parseFloat(presentPer);
                var absentPer = 100 - presentPer;

                data = {
                    datasets: [{
                        fill: true,
                        backgroundColor: [
                            '#3490dc',
                            'red'],
                        data: [presentPer, absentPer]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        'Present',
                        'Absent'
                    ]
                };

                var ctx = document.getElementById('empChart');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data
                    // options: options
                });

            }
            

        });

        function markPresent() {

            let url = "{{ url('markPresent') }}";
            document.location.href=url;

        }

        


    </script>

@endsection