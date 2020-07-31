<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <form method="POST" id="donateForm">
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">
                    <h3>Make Donation</h3>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Send Donation</button>
                    </div>
                    
                </div>
            </div>
        </form>

        <div class="modal" tabindex="-1" role="dialog" id="paymentModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Make Donation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="body"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


        <script type="text/javascript">
            $(document).ready(() => {
                $("#donateForm").submit((e) => {
                    e.preventDefault();

                    $.ajax({
                        url: `./api/make-donation`,
                        method: 'POST',
                        data: $("#donateForm").serialize(),
                    }).then((res) => {
                        $("#body").html(res);
                        $('#paymentModal').modal('show')
                    }).catch(error => {
                        handleProcessing("btnLogin", false, 'Login & Continue');
                        console.log(error);
                    });
                })
            })
        </script>
    </body>
</html>
