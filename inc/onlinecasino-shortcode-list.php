<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="casino.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css"
    integrity="sha512-72McA95q/YhjwmWFMGe8RI3aZIMCTJWPBbV8iQY3jy1z9+bi6+jHnERuNrDPo/WGYEzzNs4WdHNyyEr/yXJ9pA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    @media only screen and (max-width: 1200px) {
        #content-wrap {
            max-width: 100% !important;
        }
    }
</style>


<section class="casino_custom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">

                        <tbody>

                            <?php
                            try {

                                global $wpdb;
                                $tablename = $wpdb->prefix . 'onlinecasino_list';
                                $limit = 10;
                                if (isset($attr['limit'])) {
                                    $limit = $attr['limit'];
                                }
                                $returnRegionCasino = returnRegionCasino();
                                $sql = "SELECT * FROM $tablename WHERE status = 1 ORDER BY rating DESC LIMIT $limit";
                                if (isset($attr['region'])) {
                                    $region = $attr['region'];
                                    $sql = "SELECT * FROM $tablename WHERE status = 1 AND region = '" . $region . "' ORDER BY rating DESC LIMIT $limit";
                                } elseif (isset($returnRegionCasino) && !empty($returnRegionCasino)) {
                                    if ($returnRegionCasino == "New York" || $returnRegionCasino == "NY") {
                                        $sql = "SELECT * FROM $tablename WHERE status = 1 AND region = 'NY' ORDER BY rating DESC LIMIT $limit";
                                    }
                                    if ($returnRegionCasino == "New Jersey" || $returnRegionCasino == "NJ") {
                                        $sql = "SELECT * FROM $tablename WHERE status = 1 AND region = 'NJ' ORDER BY rating DESC LIMIT $limit";
                                    }
                                }
                                $result = $wpdb->get_results($sql);
                                $data = "";
                                $i = 1;
                                if (isset($result) && count($result) > 0) {

                                    foreach ($result as $key => $value) {
                                        $classname = ($i == 1) ? "first" : "";

                                        ?>
                                        <tr>
                                            <th scope="row" class="numbers <?= $classname ?>">#
                                                <?= $i ?>
                                            </th>
                                            <td>
                                                <div class="casino_logo">
                                                    <?php if (isset($value->accepts_us_players) && $value->accepts_us_players == "on") { ?>
                                                        <h3><img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/062016/usa_flag_correct_0.png"
                                                                alt="img" class="flag" /> Accepts US players</h3>
                                                    <?php } ?>
                                                    <a href="#" rel="nofollow">
                                                        <img src="<?= (isset($value->images)) ? $value->images : "" ?>"
                                                            alt="img" /></a>

                                                </div>
                                            </td>

                                            <td>



                                                <?php
                                                if (isset($value->signup_bonus)) {
                                                    $explode = explode(",", $value->signup_bonus);
                                                    if (is_array($explode)) {

                                                        echo '<div class="signup_bonus"><span class="counter-count">' . str_ireplace(' ', '', $explode[0]) . '</span>%<span class="upto">up to</span>$<span class="counter-count">' . str_ireplace(' ', '', $explode[1]) . '</span></div>';

                                                    }
                                                }
                                                ?>

                                            </td>
                                            <td class="hide_mbl">
                                                <div class="row--rating">
                                                    <div class="rating1">
                                                        <a href="#" rel="nofollow">
                                                            <div class="star-rating">


                                                                <div>
                                                                    <img src="https://image.ibb.co/jpMUXa/stars_blank.png"
                                                                        alt="img">
                                                                </div>
                                                                <div class="cornerimage"
                                                                    style="width:<?= ((isset($value->rating)) ? $value->rating * 10 : "") ?>%;">
                                                                    <img src="https://image.ibb.co/caxgdF/stars_full.png" alt="">
                                                                </div>

                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="rating-review">
                                                        <a class="review-link" href="#">
                                                            Review&nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hide_mbl">
                                                <div class="list games">
                                                    <span class="head">Available Games</span>
                                                    <ul>
                                                        <?php
                                                        if (isset($value->available_games)) {
                                                            $explode = explode(",", $value->available_games);
                                                            if (is_array($explode)) {

                                                                foreach ($explode as $key1 => $value1) {
                                                                    echo '<li class="active"><i class="fa fa-trophy" aria-hidden="true"></i>
                                                       ' . $value1 . '</li>';
                                                                }

                                                            }
                                                        }
                                                        ?>


                                                    </ul>
                                                </div>
                                                <div class="list methods">
                                                    <span class="head">Payment Methods</span>
                                                    <div class="payment-methods">
                                                        <ul>
                                                            <?php
                                                            if (isset($value->payment_method)) {
                                                                $paymentArray = array(
                                                                    "crypto" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfPQzruX0ZHxTDny7FYkHZi1RHeWDbXLkcxjooIrgQ4HeqZsCIyC9H78hfTDci8aDU2XE&usqp=CAU",
                                                                    "creditcard" => "https://ww2.freelogovectors.net/wp-content/uploads/2023/05/american-express-logo-freelogovectors.net_-1.png",
                                                                    "bankaccount" => "https://img.freepik.com/premium-vector/credit-cards-icon-payment-symbol-bank-account-sign_53562-15455.jpg?w=2000",
                                                                    "cashapp" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkPkkIBTYCgbLrhPxDHhsYtaj-aLE-gWjZ8A&usqp=CAU",
                                                                    "banktransfer" => "https://cdn-icons-png.flaticon.com/512/8043/8043680.png",
                                                                    "cheque" => "https://www.shutterstock.com/image-vector/blank-template-bank-check-checkbook-260nw-1360240220.jpg",
                                                                    "paypal" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8OMNR_sQEVPqLFuOMZa-JqYwMzXBYHrcRpkqkC_dp71vzVmrbvrvIercPLCG5LxBgJTs&usqp=CAU",
                                                                    "mastercard" => "https://www.investopedia.com/thmb/F8CKM3YkF1fmnRCU2g4knuK0eDY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/MClogo-c823e495c5cf455c89ddfb0e17fc7978.jpg",
                                                                    "visa" => "https://static.vecteezy.com/system/resources/previews/020/975/567/non_2x/visa-logo-visa-icon-transparent-free-png.png",
                                                                    "litecoin" => "https://e7.pngegg.com/pngimages/151/274/png-clipart-bitcoin-goes-kaboom-caveat-emptor-let-the-buyer-beware-logo-brand-number-litecoin-text-trademark.png",
                                                                    "bitcoincash" => "https://logowik.com/content/uploads/images/bitcoin-cash2558.jpg",

                                                                );
                                                                $explode = explode(",", $value->payment_method);
                                                                if (is_array($explode)) {

                                                                    foreach ($explode as $key1 => $value1) {
                                                                        $value1 = str_ireplace(' ', '', $value1);
                                                                        if (isset($paymentArray[$value1])) {
                                                                            echo ' <li>
                                                       <img src="' . $paymentArray[$value1] . '"
                                                           alt="img" />
                                                   </li>';
                                                                        }

                                                                    }

                                                                }
                                                            }
                                                            ?>


                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hide_mbl">
                                                <div class="list features">
                                                    <span class="head">Features</span>
                                                    <ul>
                                                        <?php
                                                        if (isset($value->features)) {
                                                            $explode = explode(",", $value->features);
                                                            if (is_array($explode)) {

                                                                foreach ($explode as $key1 => $value1) {
                                                                    echo '<li><i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . $value1 . '</li>';
                                                                }

                                                            }
                                                        }
                                                        ?>


                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row--rating show_mobile">
                                                    <div class="rating1">
                                                        <a href="#" rel="nofollow">
                                                            <div class="star-rating">


                                                                <div>
                                                                    <img src="https://image.ibb.co/jpMUXa/stars_blank.png"
                                                                        alt="img">
                                                                </div>
                                                                <div class="cornerimage"
                                                                    style="width:<?= ((isset($value->rating)) ? $value->rating * 10 : "") ?>%;">
                                                                    <img src="https://image.ibb.co/caxgdF/stars_full.png" alt="">
                                                                </div>

                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="rating-review">
                                                        <a class="review-link" href="#">
                                                            Review&nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <a class="casino-button"
                                                    href="<?= (isset($value->play_now_link)) ? $value->play_now_link : "#" ?>">Play
                                                    Now</a>

                                            </td>
                                        </tr>
                                        <?php
                                        $i++;

                                    }
                                } else {
                                    echo "<tr><td col-span='7'>No record found</td></tr>";
                                }

                            } catch (Exception $e) {
                                echo 'Message: ' . $e->getMessage();
                            }
                            ?>




                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    jQuery(document).ready(function ($) {

        $('.counter-count').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {

                //chnage count up speed here
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

    });

</script>