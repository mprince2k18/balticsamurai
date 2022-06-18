<?php

session_start();
require 'Helper.php';

$i = 1;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Twilio Calling Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
                <tbody>
                    <?php foreach ($all_calls['calls'] as $call) { ?>
                    <tr>
                        <th scope="row"> <?php echo $i++ ?> </th>
                        <td><?php echo $call['sid'] ?></td>
                        <td><?php echo $call['from_formatted'] ?></td>
                        <td><?php echo $call['to_formatted'] ?></td>
                        <td><?php echo $call['duration'] ?></td>
                        <td><?php echo $call['start_time'] ?></td>
                        <td><?php echo $call['end_time'] ?></td>
                        <td><?php echo $call['status'] ?></td>
                        <td>
                            <audio controls>
                                <source src="<?php echo $twilio->get_recording($call['sid']); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#<?php echo $call['sid'] ?>">
                              <?php 
                              if ($twilio->check_disputed($call['sid']) == true) {
                                echo "Disputed";
                              } else {
                                echo "Dispute";
                              }
                              ?>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $call['sid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Dispute <?php echo $call['sid'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                <?php 
                                if ($twilio->check_disputed($call['sid']) == false) { ?>

                                    <form action="store.php" method="POST">
                                        <div class="mb-3">
                                            <input type="hidden" name="caller_sid" value="<?php echo $call['sid'] ?>">
                                            <label for="exampleInputEmail1" class="form-label">Write down the reason: </label>
                                            <textarea require name="reason" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
                                        </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Dispute</button>
                                        </div>
                                    </form>
                                    <?php }else { ?>

                                        <?php echo $twilio->get_disputed_value($call['sid']) ?>

                                    <?php } ?>

                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var all_calls = <?php echo json_encode($all_calls['calls']) ?>;

            // append table row to table body
            $.each(all_calls, function(index, value) {
                $('#content').append(
                    '<tr>'+
                        '<th scope="row">'+index+'</th>'+
                            '<td>'+value['sid']+'</td>'+
                            '<td>'+value['from_formatted']+'</td>'+
                            '<td>'+value['to_formatted']+'</td>'+
                            '<td>'+value['duration']+'</td>'+
                            '<td>'+value['start_time']+'</td>'+
                            '<td>'+value['end_time']+'</td>'+
                            '<td>'+value['status']+'</td>'+
                            '<td>'+
                                '<audio controls>'+
                                    '<source src="'+value['recording_url']+'" type="audio/mpeg">'+
                                    'Your browser does not support the audio element.'+
                                '</audio>'+
                            '</td>'+
                            '<td>'+
                                '<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#'+value['sid']+'">'+
                                    'TODO'
                                    +
                                '</button>'+
                                '<div class="modal fade" id="'+value['sid']+'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                                    '<div class="modal-dialog">'+
                                        '<div class="modal-content">'+
                                            '<div class="modal-header">'+
                                                '<h5 class="modal-title" id="exampleModalLabel">Dispute '+value['sid']+'</h5>'+
                                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+
                                            '</div>'+
                                            '<div class="modal-body">'+
                                                '<form action="store.php" method="POST">'+
                                                    '<div class="mb-3">'+
                                                        '<input type="hidden" name="caller_sid" value="'+value['sid']+'">'+
                                                        '<label for="exampleInputEmail'+value['sid']+'" class="form-label">Write down the reason: </label>'+
                                                        '<textarea require name="reason" class="form-control" id="exampleInputEmail'+value['sid']+'" aria-describedby="emailHelp" placeholder="Enter reason"></textarea>'+
                                                        '<div class="modal-footer">'+
                                                            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>'+
                                                            '<button type="submit" class="btn btn-primary">Dispute</button>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</form>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                        '</tr>');
            });
        });

    </script>
  </body>
</html>