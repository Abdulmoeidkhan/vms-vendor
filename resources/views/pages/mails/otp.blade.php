<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OTP for Profile Activation</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #046C04;
            color: white;
        }
    </style>
</head>

<body class="antialiased">
    <div class="container">
        <h2>THANK YOU FOR Signing In {{$user->name}}</h2>
        <h3>Welcome to IDEAS 2024 as official vendor / service provider.</h3>
        <p>Kindly find below the login details to enter your staff’s data for the security clearance and badges.</p>
        <p>
            Please check your details.
        </p>
        <br />
        <table id="customers">
            <tr>
                <th>Fields</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Email Id</td>
                <td>{{$user->email}}</td>
            </tr>
            {{-- <tr>
                <td>Otp</td>
                <td>{{$user->activation_code}}</td>
            </tr> --}}
            <tr>
                <td>Portal</td>
                <td>{{url('')}}</td>
            </tr>
        </table>
        <h3>Note :</h3>
        <p>In order to facilitate you, we have introduced Badar Expo Mobile App so you may download it from Google play
            and App store, and get yourself and your friends / colleagues and customers for obtaining the visitor badges
            for all the events of Badar Expo Solutions.</p>
    </div>
</body>

</html>