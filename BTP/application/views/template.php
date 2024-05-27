<?php
$this->load->view('template/header'); 
$user=$this->session->userdata("user"); ?>
<div class="container-scroller">
<!-- <?php  if(isset($user[0]['admin'])){ $this->load->view('template/_navbar'); } else{ $this->load->view('template/_navbar_client'); }?> -->
<?php  $this->load->view('template/_navbar'); ?>
    <div class="container-fluid page-body-wrapper"> 
        
         <?php  $this->load->view('template/_sidebar');  ?>


        <div class="main-panel">
            <div class="content-wrapper">
                <?php  $this->load->view($content); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/footer'); ?>
