<?php

session_start();
require 'Helper.php';

$direct_mails = new Information;

$i = 1;

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://rawgit.com/enbifa/jquery.skeleton.loader/master/example/css/jquery.skeleton.css">
    <link href="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.css" rel="stylesheet"
        type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/mobius1/selectr@latest/dist/selectr.min.js" type="text/javascript">
    </script>
</head>

<body>

    <div class="container-fluid p-4">

        <div class="row">
            <div class="col-md-12">
                <a href="index.php">
                    <h1 class="text-center">Leads</h1>
                </a>
            </div>

            <div class="col-md-12">

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary text-end" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Add New Leads
                </button>

                
                <form action="search.php" method="GET">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="source" class="form-label">Source</label>
                                <select class="form-select" aria-label="Select Source" name="source" onchange="Source(value)">
                                    <option value="" selected>Select Source</option>
                                    <option value="Tawkto">Tawkto</option>
                                    <option value="Twilio">Twilio</option>
                                    <option value="DirectMails">DirectMails</option>
                                    <option value="GB">Google Business</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date & Time</label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary text-end">
                        Search
                    </button>
                </form>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Leads</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="store.php" method="post">

                                    <div class="mb-3">
                                        <label for="source" class="form-label">Source</label>
                                        <select class="form-select" aria-label="Select Source" name="source"
                                            onchange="Source(value)">
                                            <option selected>Select Source</option>
                                            <option value="Tawkto">Tawkto</option>
                                            <option value="Twilio">Twilio</option>
                                            <option value="DirectMails">DirectMails</option>
                                            <option value="GB">Google Business</option>
                                        </select>
                                    </div>

                                    <div class="d-none Default">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" placeholder="Full Name" class="form-control" id="name"
                                                name="name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" placeholder="Email Address" class="form-control"
                                                name="email" id="email">
                                        </div>

                                        <div class="mb-3 ShowIfGB d-none">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" placeholder="Phone Number" class="form-control"
                                                name="phone" id="phone">
                                        </div>

                                        <div class="mb-3 ShowIfTawkto ShowIfTwilio d-none">
                                            <label for="country" class="form-label">Country Name</label>
                                            <input type="text" placeholder="Country Name" class="form-control"
                                                name="country" id="country">
                                        </div>

                                        <div class="mb-3 ShowIfTawkto ShowIfTwilio d-none">
                                            <label for="city" class="form-label">City Name</label>
                                            <input type="text" placeholder="City Name" class="form-control" name="city"
                                                id="city">
                                        </div>

                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="date" id="date">
                                        </div>

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
                    echo "<h5 class='mt-4'>".$_SESSION['message']."</h5>";
                    unset($_SESSION['message']);
                }
            ?>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Country</th>
                        <th scope="col">City</th>
                        <th scope="col">Source</th>
                        <th scope="col">Data & Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($direct_mails->allContacts() as $contact) { ?>
                    <tr class="loader">
                        <td>
                            <?php echo $i++; ?>
                        </td>
                        <td>
                            <?php 
                                if (isset($contact['name'])) {
                                    echo $contact['name'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (isset($contact['email'])) {
                                    echo $contact['email'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (isset($contact['phone'])) {
                                    echo $contact['phone'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if (isset($contact['country'])) {
                                    echo $contact['country'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if (isset($contact['city'])) {
                                    echo $contact['city'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if (isset($contact['source'])) {
                                    echo $contact['source'];
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if (isset($contact['date'])) {
                                    echo date('d-m-Y H:i:s', strtotime($contact['date']));
                                }else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>

                            <?php if($direct_mails->check_disputed($contact['id']) == 'Dispute') {?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $contact['id']; ?>">
                                Dispute
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $contact['id']; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel<?php echo $contact['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Dispute
                                                <?php echo $contact['name']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="reason.php" method="POST">
                                                <div class="mb-3">
                                                    <input type="hidden" name="directmail_id"
                                                        value="<?php echo $contact['id']; ?>">
                                                    <label for="exampleInputEmail1" class="form-label">Write down the
                                                        dispute reason:</label>
                                                    <textarea name="reason" class="form-control" id="exampleInputEmail1"
                                                        require></textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#Disputed<?php echo $contact['id']; ?>">
                                Disputed
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="Disputed<?php echo $contact['id']; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel<?php echo $contact['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <?php echo $contact['name']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <?php echo $contact['reason']; ?>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php } ?>

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
        "use strict";
        $(document).ready(function () {

            var instance = $('.myDIV').scheletrone({
                incache: false,
                removeIframe: true,
                maskText: true,
                skelParentText: false,
                backgroundImage: true,
            });

        });

        function Source(value) {
            $('.Default').removeClass('d-none');
            switch (value) {
                case 'Tawkto':
                    $('.ShowIfTwilio').addClass('d-none');
                    $('.ShowIfGB').addClass('d-none');
                    $('.ShowIfTawkto').removeClass('d-none');
                    break;
                case 'Twilio':
                    $('.ShowIfTawkto').addClass('d-none');
                    $('.ShowIfGB').addClass('d-none');
                    $('.ShowIfTwilio').removeClass('d-none');
                    break;
                case 'DirectMails':
                    $('.ShowIfTawkto').addClass('d-none');
                    $('.ShowIfGB').addClass('d-none');
                    $('.ShowIfTwilio').addClass('d-none');
                    break;
                case 'GB':
                    $('.ShowIfTawkto').addClass('d-none');
                    $('.ShowIfTwilio').addClass('d-none');
                    $('.ShowIfGB').removeClass('d-none');
                    break;

                default:
                    break;
            }
        }
    </script>
</body>

</html>