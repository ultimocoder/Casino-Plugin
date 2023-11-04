<?php
if (isset($_POST['submit_casino_update'])) {

    //upload image
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
    }

    $imageurl = $_POST['brand_logo'];

    if (isset($_FILES['brand_logo_new'])) {
        $uploadedfile1 = $_FILES['brand_logo_new'];
        $upload_overrides1 = array('test_form' => false);

        $movefile1 = wp_handle_upload($uploadedfile1, $upload_overrides1);

        if ($movefile1 && !isset($movefile1['error'])) {
            $imageurl = $movefile1['url'];

        } else {
            // echo $movefile1['error'];
        }
    }


    // end upload image

    global $wpdb;


    $tablename = $wpdb->prefix . 'onlinecasino_list';

    $parameter1 = $_POST['uid'];

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
    $data_to_update = array(
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
        'status' => 1,
        'order' => 1,
        'region' => $region
    );



    $where_condition = array(
        'id' => $parameter1,
    );
    if (isset($parameter1) && !empty($parameter1)) {
        $update = $wpdb->update($tablename, $data_to_update, $where_condition);
        if (isset($update)) {
            $msg = "Successfully updated casino post";
        }

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
</style>

<?php
if (isset($_GET['uid']) && !empty($_GET['uid'])) {


    $uid = $_GET['uid'];

    global $wpdb;
    $tablename = $wpdb->prefix . 'onlinecasino_list';
    $result = $wpdb->get_results("SELECT * FROM $tablename WHERE id = $uid ");

    $signup_bonus_percentage = "";
    $signup_bonus_up = "";

    if (isset($result[0]->signup_bonus)) {
        $explode = explode(",", $result[0]->signup_bonus);
        if (is_array($explode)) {
            $signup_bonus_percentage = $explode[0];
            $signup_bonus_up = $explode[1];
        }
    }
    $payment_method = str_replace(" ", "", $result[0]->payment_method);
    $payment_method = explode(",", $payment_method);
    ?>

    <section class="casino_form">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">
                    <h3 class="" style="text-align:center;color:#333;">Update casino post</h3>
                    <?php
                    if (isset($msg) && !empty($msg)) {
                        echo '<h5 class="" style="text-align:center;color:green;">' . $msg . '</h5>';
                    }
                    ?>
                    <form action="<?= site_url() ?>/wp-admin/admin.php?page=onlinecasino-list&uid=<?= $uid ?>" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="uid" value="<?= $uid ?>">
                        <div class="mb-4">

                            <label for="title" class="form-label">Title</label>

                            <input type="text" name="title" placeholder="Enter title" id="title" class="form-control"
                                value="<?= (isset($result[0]->title)) ? $result[0]->title : "" ?>">

                        </div>

                        <div class="mb-4">

                            <label for="brand_logo" class="form-label">Brand Logo</label>
                            <?php
                            if (isset($result[0]->images) && !empty($result[0]->images)) {
                                echo '<img src="' . $result[0]->images . '" width="100" height="100">';
                            }
                            ?>

                            <input type="file" class="form-control" name="brand_logo_new" id="brand_logo">
                            <input type="hidden" name="brand_logo"
                                value="<?= (isset($result[0]->images)) ? $result[0]->images : "" ?>">


                        </div>

                        <div class="mb-4">

                            <label for="signup_bonus_percentage" class="form-label">Signup Bonus Percentage</label>


                            <input type="text" placeholder="Enter Bonus Percentage" class="form-control"
                                name="signup_bonus_percentage" id="signup_bonus_percentage" required
                                value="<?= (isset($signup_bonus_percentage)) ? $signup_bonus_percentage : "" ?>">


                        </div>

                        <div class="mb-4">

                            <label for="signup_bonus_up" class="form-label">Signup Bonus up Amount</label>

                            <input type="text" placeholder="Enter Bonus up Amount" class="form-control" id="signup_bonus_up"
                                name="signup_bonus_up" required
                                value="<?= (isset($signup_bonus_up)) ? $signup_bonus_up : "" ?>">

                        </div>

                        <div class="mb-4">

                            <label for="rating" class="form-label">Reviews</label>

                            <select class="form-control" name="rating" id="rating" required>

                                <option value="1" <?= (isset($result[0]->rating) && $result[0]->rating == "1") ? "selected" : "" ?>>1</option>

                                <option value="2" <?= (isset($result[0]->rating) && $result[0]->rating == "2") ? "selected" : "" ?>>2</option>

                                <option value="3" <?= (isset($result[0]->rating) && $result[0]->rating == "3") ? "selected" : "" ?>>3</option>

                                <option value="4" <?= (isset($result[0]->rating) && $result[0]->rating == "4") ? "selected" : "" ?>>4</option>

                                <option value="5" <?= (isset($result[0]->rating) && $result[0]->rating == "5") ? "selected" : "" ?>>5</option>

                                <option value="6" <?= (isset($result[0]->rating) && $result[0]->rating == "6") ? "selected" : "" ?>>6</option>

                                <option value="7" <?= (isset($result[0]->rating) && $result[0]->rating == "7") ? "selected" : "" ?>>7</option>

                                <option value="8" <?= (isset($result[0]->rating) && $result[0]->rating == "8") ? "selected" : "" ?>>8</option>

                                <option value="9" <?= (isset($result[0]->rating) && $result[0]->rating == "9") ? "selected" : "" ?>>9</option>

                                <option value="10" <?= (isset($result[0]->rating) && $result[0]->rating == "10") ? "selected" : "" ?>>10</option>

                            </select>



                        </div>


                        <div class="mb-4">

                            <label for="region" class="form-label">Region</label>

                            <select class="form-control" name="region" id="region" required>

                                <option value="NY" <?= (isset($result[0]->region) && $result[0]->region == "NY") ? "selected" : "" ?>>NY</option>

                                <option value="NJ" <?= (isset($result[0]->region) && $result[0]->region == "NJ") ? "selected" : "" ?>>NJ</option>

                            </select>



                        </div>

                        <div class="mb-4">

                            <label for="available_games" class="form-label">Available Games</label>

                            <textarea class="form-control" name="available_games" id="available_games"
                                placeholder="Enter Game List for example - List1, List2"
                                required><?= (isset($result[0]->available_games)) ? $result[0]->available_games : "" ?></textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">Pament Method</label>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="Crypto" name="payment_method[]"
                                    value="crypto" <?= (in_array('crypto', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="Crypto">Crypto</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="creditcard" name="payment_method[]"
                                    value="creditcard" <?= (in_array('creditcard', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="creditcard">Credit Card</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="bankaccount" name="payment_method[]"
                                    value="bankaccount" <?= (in_array('bankaccount', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="bankaccount">Bank Account</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="americanexpress" name="payment_method[]"
                                    value="americanexpress" <?= (in_array('americanexpress', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="americanexpress">American Express</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="cashapp" name="payment_method[]"
                                    value="cashapp" <?= (in_array('cashapp', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="cashapp">Cash App</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="banktransfer" name="payment_method[]"
                                    value="banktransfer" <?= (in_array('banktransfer', $payment_method)) ? "checked" : "" ?>>

                                <label class="form-check-label" for="banktransfer">Bank Transfer</label>

                            </div>


                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="cheque" name="payment_method[]"
                                    value="cheque" <?= (in_array('banktransfer', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="cheque">Cheque</label>

                            </div>


                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="paypal" name="payment_method[]"
                                    value="paypal" <?= (in_array('paypal', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="paypal">Paypal</label>

                            </div>


                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="mastercard" name="payment_method[]"
                                    value="mastercard" <?= (in_array('mastercard', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="mastercard">Master Card</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="visa" name="payment_method[]"
                                    value="visa" <?= (in_array('visa', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="visa">Visa</label>

                            </div>

                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="litecoin" name="payment_method[]"
                                    value="litecoin" <?= (in_array('litecoin', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="litecoin">Litecoin</label>

                            </div>


                            <div class="form-check">

                                <input type="checkbox" class="form-check-input" id="bitcoincash" name="payment_method[]"
                                    value="bitcoincash" <?= (in_array('bitcoincash', $payment_method)) ? "cheque" : "" ?>>

                                <label class="form-check-label" for="bitcoincash">Bitcoin Cash</label>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label for="features" class="form-label">Features of Site</label>

                            <textarea class="form-control" name="features" id="features"
                                placeholder="Enter Features for example - Feature 1,  Feature 2 etc."
                                required><?= (isset($result[0]->features)) ? $result[0]->features : "" ?></textarea>



                        </div>


                        <div class="mb-4">

                            <label for="play_now_link" class="form-label">Play now link</label>

                            <input type="text" placeholder="Enter Play now link" class="form-control" id="play_now_link"
                                name="play_now_link"
                                value="<?= (isset($result[0]->play_now_link)) ? $result[0]->play_now_link : "" ?>">

                        </div>

                        <div class="mb-4">

                            <label for="read_reviews" class="form-label">Read reviews link</label>

                            <input type="text" placeholder="Enter Read reviews link" class="form-control" id="read_reviews"
                                name="read_reviews"
                                value="<?= (isset($result[0]->read_reviews)) ? $result[0]->read_reviews : "" ?>">

                        </div>

                        <div class="mb-4 form-check">

                            <input type="checkbox" class="form-check-input" id="acceptusplayers" name="accepts_us_players"
                                <?= (isset($result[0]->accepts_us_players) && $result[0]->accepts_us_players == "on") ? "checked" : "" ?>>

                            <label class="form-check-label" for="acceptusplayers">Accepts US Players</label>

                        </div>

                        <button type="submit" class="btn btn-primary" name="submit_casino_update">Update now</button>

                    </form>



                </div>

            </div>

        </div>

    </section>


    <style>
        button.btn.btn-primary {
            background: #FF233B;
            border-color: #FF233B;
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php
}
?>