<?php
if (isset($_POST['submit_casino'])) {

    //upload image
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
    }



    $uploadedfile1 = $_FILES['brand_logo'];
    $upload_overrides1 = array('test_form' => false);

    $movefile1 = wp_handle_upload($uploadedfile1, $upload_overrides1);
    $imageurl = "";

    if ($movefile1 && !isset($movefile1['error'])) {
        $imageurl = $movefile1['url'];

    } else {
        echo $movefile1['error'];
    }
    // end upload image

    global $wpdb;


    $tablename = $wpdb->prefix . 'onlinecasino_list';

    $title = (isset($_POST['title'])) ? $_POST['title'] : "";
    $play_now_link = (isset($_POST['play_now_link'])) ? $_POST['play_now_link'] : "";
    $read_reviews = (isset($_POST['read_reviews'])) ? $_POST['read_reviews'] : "";
    $accepts_us_players = (isset($_POST['accepts_us_players'])) ? $_POST['accepts_us_players'] : "0";
    $features = (isset($_POST['features'])) ? $_POST['features'] : "";
    $rating = (isset($_POST['rating'])) ? $_POST['rating'] : "";
    $region = (isset($_POST['region'])) ? $_POST['region'] : "";
    $available_games = (isset($_POST['available_games'])) ? $_POST['available_games'] : "";

    $signup_bonus = $_POST['signup_bonus_percentage'] . " , " . $_POST['signup_bonus_up'];

    $payment_method = implode(", ", $_POST['payment_method']);

    $date = date("Y-m-d");
    $data = array(
        'title' => $title,
        'images' => $imageurl,
        'play_now_link' => $play_now_link,
        'signup_bonus' => $signup_bonus,
        'read_reviews' => $read_reviews,
        'accepts_us_players' => $accepts_us_players,
        'available_games' => $available_games,
        'payment_method' => $payment_method,
        'features' => $features,
        'rating' => $rating,
        'created' => $date,
        'status' => 1,
        'order' => 1,
        'region' => $region
    );


    $insert = $wpdb->insert($tablename, $data);

    if (isset($insert)) {
        $msg = "Successfully inserted casino post";
    }





















}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<link href="casino.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css"
    integrity="sha512-72McA95q/YhjwmWFMGe8RI3aZIMCTJWPBbV8iQY3jy1z9+bi6+jHnERuNrDPo/WGYEzzNs4WdHNyyEr/yXJ9pA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .casino_form {

        max-width: 600px;

        margin: 30px auto;

    }

    .casino_form .form-label {

        font-weight: 500;

    }

    .casino_form .form-control {

        background: #f2f2f2;

    }

    .casino_form .form-check-input {

        margin: 0.4rem .25rem 0 -1.5em;

    }

    button.btn.btn-primary {
        background: #FF233B;
        border-color: #FF233B;
    }
</style>

<section class="casino_form">

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">
                <h3 class="" style="text-align:center;color:#333;">Add new casino</h3>
                <?php
                if (isset($msg) && !empty($msg)) {
                    echo '<h5 class="" style="text-align:center;color:green;">' . $msg . '</h5>';
                }
                ?>
                <form action="<?= site_url() ?>/wp-admin/admin.php?page=onlinecasinomenu" method="POST"
                    enctype="multipart/form-data">

                    <div class="mb-4">

                        <label for="title" class="form-label">Title</label>

                        <input type="text" name="title" placeholder="Enter title" id="title" class="form-control"
                            required>

                    </div>

                    <div class="mb-4">

                        <label for="brand_logo" class="form-label">Brand Logo</label>

                        <input type="file" class="form-control" name="brand_logo" id="brand_logo" required>


                    </div>

                    <div class="mb-4">

                        <label for="signup_bonus_percentage" class="form-label">Signup Bonus Percentage</label>

                        <input type="text" placeholder="Enter Bonus Percentage" class="form-control"
                            name="signup_bonus_percentage" id="signup_bonus_percentage" required>


                    </div>

                    <div class="mb-4">

                        <label for="signup_bonus_up" class="form-label">Signup Bonus up Amount</label>

                        <input type="text" placeholder="Enter Bonus up Amount" class="form-control" id="signup_bonus_up"
                            name="signup_bonus_up" required>

                    </div>

                    <div class="mb-4">

                        <label for="rating" class="form-label">Reviews</label>

                        <select class="form-control" name="rating" id="rating" required>

                            <option value="1">1</option>

                            <option value="2">2</option>

                            <option value="3">3</option>

                            <option value="4">4</option>

                            <option value="5">5</option>

                            <option value="6">6</option>

                            <option value="7">7</option>

                            <option value="8">8</option>

                            <option value="9">9</option>

                            <option value="10">10</option>

                        </select>



                    </div>


                    <div class="mb-4">

                        <label for="region" class="form-label">Region</label>

                        <select class="form-control" name="region" id="region" required>

                            <option value="NY">NY</option>

                            <option value="NJ">NJ</option>

                        </select>



                    </div>

                    <div class="mb-4">

                        <label for="available_games" class="form-label">Available Games</label>

                        <textarea class="form-control" name="available_games" id="available_games"
                            placeholder="Enter Game List for example - List1, List2" required></textarea>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">Pament Method</label>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="Crypto" name="payment_method[]"
                                value="crypto" >

                            <label class="form-check-label" for="Crypto">Crypto</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="creditcard" name="payment_method[]"
                                value="creditcard">

                            <label class="form-check-label" for="creditcard">Credit Card</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="bankaccount" name="payment_method[]"
                                value="bankaccount">

                            <label class="form-check-label" for="bankaccount">Bank Account</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="americanexpress" name="payment_method[]"
                                value="americanexpress">

                            <label class="form-check-label" for="americanexpress">American Express</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="cashapp" name="payment_method[]"
                                value="cashapp">

                            <label class="form-check-label" for="cashapp">Cash App</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="banktransfer" name="payment_method[]"
                                value="banktransfer">

                            <label class="form-check-label" for="banktransfer">Bank Transfer</label>

                        </div>


                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="cheque" name="payment_method[]"
                                value="cheque">

                            <label class="form-check-label" for="cheque">Cheque</label>

                        </div>


                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="paypal" name="payment_method[]"
                                value="paypal">

                            <label class="form-check-label" for="paypal">Paypal</label>

                        </div>


                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="mastercard" name="payment_method[]"
                                value="mastercard">

                            <label class="form-check-label" for="mastercard">Master Card</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="visa" name="payment_method[]"
                                value="visa">

                            <label class="form-check-label" for="visa">Visa</label>

                        </div>

                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="litecoin" name="payment_method[]"
                                value="litecoin">

                            <label class="form-check-label" for="litecoin">Litecoin</label>

                        </div>


                        <div class="form-check">

                            <input type="checkbox" class="form-check-input" id="bitcoincash" name="payment_method[]"
                                value="bitcoincash">

                            <label class="form-check-label" for="bitcoincash">Bitcoin Cash</label>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label for="features" class="form-label">Features of Site</label>

                        <textarea class="form-control" name="features" id="features"
                            placeholder="Enter Features for example - Feature 1,  Feature 2 etc." required></textarea>



                    </div>


                    <div class="mb-4">

                        <label for="play_now_link" class="form-label">Play now link</label>

                        <input type="text" placeholder="Enter Play now link" class="form-control" id="play_now_link"
                            name="play_now_link" value="">

                    </div>

                    <div class="mb-4">

                        <label for="read_reviews" class="form-label">Read reviews link</label>

                        <input type="text" placeholder="Enter Read reviews link" class="form-control" id="read_reviews"
                            name="read_reviews" value="">

                    </div>

                    <div class="mb-4 form-check">

                        <input type="checkbox" class="form-check-input" id="acceptusplayers" name="accepts_us_players">

                        <label class="form-check-label" for="acceptusplayers">Accepts US Players</label>

                    </div>

                    <button type="submit" class="btn btn-primary" name="submit_casino">Submit</button>

                </form>



            </div>

        </div>

    </div>

</section>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>