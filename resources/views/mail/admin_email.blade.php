<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <title>Pharma</title>
</head>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="text-center mt-5"><img src="https://stagapp.contactapharmacy.it/assets/emailimages/logo.png" width="50%" alt="logo">
            </div>
            <div class="text-center mt-5"> <img src="https://stagapp.contactapharmacy.it/assets/emailimages/1.jpg" width="75%"
                    alt="image">
            </div>
        </div>
        <div class="container">
            <div class="text-center pt-5">
                <h2>
                    <p style="border-bottom: 2px solid ;">CIAO amministratore</p>
                </h2> 
            </div>
            <p class="text-center">{{ $data['name'] }}, hai ricevuto un appuntamento per la Telemedicina </p>
            <p class="text-center">{{ $data['date'] }} alle {{ $data['starttime'] }} </p>
            <p class="text-center">{{ $data['subject'] }}</p>

            <h3>Grazie</h3>

            <!-- <div class="text-center"><button class="btn btn-lg btn-success ps-5 pe-5 mt-3"
                    style="border-radius: 30px;">Check App</button></div>
        </div> -->
        <hr class="mt-5">
    </div>