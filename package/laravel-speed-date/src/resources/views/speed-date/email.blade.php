<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        h1 {
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            background-color: #fff;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
                /* Make table responsive */
        @media screen and (max-width: 600px) {
            th, td {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div style="padding: 20px;">
        <h1>Hello, {{ $participant->name }}!</h1>
        <p>Event Name: {{ $participant->events()->latest('created_at')->first()->name }} </p>
        <p>Event Date: {{ $participant->events()->latest('created_at')->first()->happens_on->format('F j, Y h:i A') }} </p>
        @if($users->isNotEmpty())
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Nick Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Occupation</th>
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Rating (To You)</th>
                        <th>Rating (From You)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}
                                {{-- <a href="{{ route('users.show', $user->id) }}"
                                    style="text-decoration: underline; color: #007bff; text-decoration-color: #007bff;">
                                     <div class="d-flex align-items-center">
                                         <div class="rounded-circle overflow-hidden mr-2"
                                              style="width: 40px; height: 40px;">
                                             <img src="{{ asset($user->avatar) }}"
                                                  alt="{{ $user->name }}"
                                                  class="w-100 h-100">
                                         </div>
                                         <span class="ml-2"
                                               style="margin-left: 8px !important;">{{ $user->name }}</span>
                                     </div>
                                 </a> --}}
                            </td>
                            <td>{{ $user->bio->nickname }}</td>
                            <td>{{ $user->bio->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->bio->phone }}</td>
                            <td>{{ $user->bio->city }}</td>
                            <td>{{ $user->bio->occupation }}</td>
                            <td>{{ $user->bio->birthdate }}</td>
                            <td>{{ $user->bio->gender }}</td>
                            <td>{{ $user->eventRatingsGiven->last()->rating }}</td>
                            <td>{{ $user->eventRatingsReceived->last()->rating }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else

        <p>Better Luck Next Time</p>

        @endif
    </div>
</body>
</html>
