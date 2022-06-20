<?php

session_start();
require 'Helper.php';

$tawkto = new Tawkto;

$i = 1;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Twilio Calling Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://rawgit.com/enbifa/jquery.skeleton.loader/master/example/css/jquery.skeleton.css">
    <link href="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js" type="text/javascript"></script>
</head>
  <body>

    <div class="container-fluid p-4">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Tawkto Contacts</h1>
            </div>

            <div class="col-md-12">
                
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary text-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add New Contacts
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal"data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Tawto Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="store.php" method="post">

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" placeholder="Full Name" class="form-control" id="name" name="name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" placeholder="Email Address" class="form-control" name="email" id="email">
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country Name</label>
                                <input type="text" placeholder="Country Name" class="form-control" name="country" id="country">
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City Name</label>
                                <input type="text" placeholder="City Name" class="form-control" name="city" id="city">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>

                        </form>

                    </div>
                    </div>
                </div>
                </div>

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
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tawkto->allContacts() as $contact) { ?>
                    <tr class="loader">
                        <td>
                            <?php echo $i++; ?>
                        </td>
                        <td>
                            <?php echo $contact['name']; ?>
                        </td>
                        <td>
                            <?php echo $contact['email']; ?>
                        </td>
                        <td>
                            <?php echo $contact['country']; ?>
                        </td>
                        <td>
                            <?php echo $contact['city']; ?>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $contact['id']; ?>">
                                    Dispute
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $contact['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $contact['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Dispute <?php echo $contact['name']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
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
        });

        new Selectr(document.getElementById('country'));

    </script>
  </body>
</html>