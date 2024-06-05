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
            <tr>
                <td>Otp</td>
                <td>{{$user->activation_code}}</td>
            </tr>
        </table>
    </div>
</body>

</html>