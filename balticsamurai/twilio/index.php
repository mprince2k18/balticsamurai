<?php

session_start();
require 'Helper.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Twilio Calling Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://rawgit.com/enbifa/jquery.skeleton.loader/master/example/css/jquery.skeleton.css">
  </head>
  <body>

    <div class="container-fluid p-4">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Twilio Calling Logs</h1>
            </div>

            <?php
                if(isset($_SESSION['message']))
                {
                    echo "<h5>".$_SESSION['message']."</h5>";
                    unset($_SESSION['message']);
                }
            ?>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">SID</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Recording</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="content">
                    <?php for ($i=0; $i < 10; $i++) { ?>
                    <tr class="loader">
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">#</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">SID</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">From</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">To</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">Duration</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">Start Date</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">End Date</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">Status</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">Recording</span>
                            </div>
                        </td>
                        <td>
                            <div class="myDIV">
                                <span data-scheletrone="true">Action</span>
                            </div>
                        </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://rawgit.com/enbifa/jquery.skeleton.loader/master/src/jquery.scheletrone.js"></script>
    <script>
        $(document).ready(function() {

            var instance = $('.myDIV').scheletrone({
                incache: false,
                removeIframe: true,
                maskText: true,
                skelParentText: false,
                backgroundImage: true,
            });

            // ajax request to get all call logs
            $.ajax({
                url: 'get_all_call_logs.php',
                type: 'GET',
                async: true,
                crossDomain: true,
                dataType: 'json',
                crossOrigin: true,
                headers: {
                    'Access-Control-Allow-Methods': '*',
                    "Access-Control-Allow-Credentials": true,
                    "Access-Control-Allow-Headers" : "Access-Control-Allow-Headers, Origin, X-Requested-With, Content-Type, Accept, Authorization",
                    "Access-Control-Allow-Origin": "*",
                    "Control-Allow-Origin": "*",
                    "cache-control": "no-cache",
                    'Content-Type': 'application/json'
                },
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function(data) {
                    $('.loader').hide();
                    $('#content').append(data);
                }

            });

        });
    </script>
  </body>
</html>