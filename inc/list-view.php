<?php 
if(isset($_GET['uid']) && !empty($_GET['uid'])){
  require_once plugin_dir_path( __FILE__ ) . 'edit-list.php';
}else{


?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css"
  integrity="sha512-72McA95q/YhjwmWFMGe8RI3aZIMCTJWPBbV8iQY3jy1z9+bi6+jHnERuNrDPo/WGYEzzNs4WdHNyyEr/yXJ9pA=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
  .casino_list table img {

    max-width: 130px;

  }
  .casino_list .btn-primary {
      background: #FF233B;
      border-color: #FF233B;
  }
  .casino_list table tr th, .casino_list table tr td {
      vertical-align: middle;
  }
  button.btn.btn-primary.edit a{
    color: #fff;
    text-decoration: none;
  }

  button.btn.btn-primary.edit {
    padding: 0;
}

button.btn.btn-primary.edit a {
--bs-btn-padding-x: 0.75rem;
    --bs-btn-padding-y: 0.375rem;
    --bs-btn-font-family: ;
    --bs-btn-font-size: 1rem;
    --bs-btn-font-weight: 400;
    --bs-btn-line-height: 1.5;
    --bs-btn-color: var(
    --bs-body-color);
    --bs-btn-bg: transparent;
    --bs-btn-border-width: var(
    --bs-border-width);
    --bs-btn-border-color: transparent;
    --bs-btn-border-radius: var(
    --bs-border-radius);
    --bs-btn-hover-border-color: transparent;
    --bs-btn-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15),0 1px 1px rgba(0, 0, 0, 0.075);
    --bs-btn-disabled-opacity: 0.65;
    --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(
    --bs-btn-focus-shadow-rgb), .5);
    display: inline-block;
    padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
    font-family: var(--bs-btn-font-family);
    font-size: var(--bs-btn-font-size);
    font-weight: var(--bs-btn-font-weight);
    line-height: var(--bs-btn-line-height);
    color: var(--bs-btn-color);
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
    border-radius: var(--bs-btn-border-radius);
    background-color: var(--bs-btn-bg);
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    color: #fff !important;
}
  
</style>

<section class="casino_list mt-5">

  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-12">

        <table class="table table-bordered">

          <thead class="table-dark">

            <tr>

              <th scope="col">Sr. No.</th>

              <th scope="col">Brand logo</th>

              <th scope="col">Title</th>

              <th scope="col">Region</th>

              <th scope="col">Action</th>

            </tr>

          </thead>

          <tbody>

            <?php


            global $wpdb;
            $tablename = $wpdb->prefix . 'onlinecasino_list';
            $result = $wpdb->get_results("SELECT * FROM $tablename WHERE status = 1 ORDER BY id ASC");
            $data = "";
            $i = 1;
            if (isset($result) && count($result) > 0) {

              foreach ($result as $key => $value) {
                ?>

                <tr>

                  <th scope="row">
                    <?= $i ?>
                  </th>

                  <td><img src="<?= $value->images ?>" alt="img" />

                  </td>

                  <td>
                    <?= $value->title ?>
                  </td>

                  <td>
                    <?= $value->region ?>
                  </td>

                  <td><button type="button" class="btn btn-primary edit" data-id="<?= $value->id ?>"><a href="<?= site_url() ?>/wp-admin/admin.php?page=onlinecasino-list&uid=<?= $value->id ?>">Edit</a></button> <button
                      data-id="<?= $value->id ?>" type="button" class="btn btn-primary delete">Delete</button></td>

                </tr>

                <?php
                $i++;
              }
            }
            else{
                echo '<tr><td colspan="4">No record found</td></tr>';
            }
            ?>







          </tbody>

        </table>

      </div>

    </div>

  </div>

</section>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
  jQuery(document).ready(function () {

    jQuery(".delete").click(function () {
      var dataid = jQuery(this).attr("data-id");
      var thisVar = jQuery(this);

      if (!confirm("Are you sure you want to delete post?")) {
        return false;
      }
      thisVar.text("Processing...");
      jQuery.ajax({
        url: '<?= admin_url('admin-ajax.php') ?>', // Defined in your functions.php file
        type: 'POST',
        data: {
          action: 'delete_casino_post', // Custom action name
          parameter1: dataid
        },
        success: function (response) {
          if (response.valid) {
            thisVar.text("Deleted successfully");
            setTimeout(function () {
              thisVar.closest("tr").remove();
            }, 3000);

          }


        }
      });

    });
  });
</script>
<?php 
}
?>