<!-- Page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4></i> <span class="text-semibold"><?php _el('dashboard'); ?></span></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i><?php _el('dashboard'); ?> </a>
			</li>
		</ul>
	</div>
</div>
<!-- /Page header -->
<!-- Content area -->
<div class="content">
	<div class="row">
		<div class="col-lg-3 col-6">

			<div class="small-box bg-info">
				<div class="inner">
					<h1><?php
					 if(isset($count_verified)){ echo $count_verified; } ?></h1>
					<p>Verified Users</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="./users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>


		<div class="col-lg-3 col-6">

			<div class="small-box bg-danger">
				<div class="inner">
					<h1><?php
					 if(isset($count_users_attch)){ echo $count_users_attch[0]['count_users_attch']; } ?></h1>
					<p>Active & verified users with attached active products</p>
				</div>
				<div class="icon">
					<i class="ion ion-pie-graph"></i>
				</div>
				<a href="./users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>



		<div class="col-lg-3 col-6">

			<div class="small-box bg-success">
				<div class="inner">
					<h1><?php
					 if(isset($active_products)){ echo $active_products; } ?></h1>
					<p>Active Products</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="./products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3 col-6">

			<div class="small-box bg-warning">
				<div class="inner">
					<h1><?php
					 if(isset($active_products_not_attch)){ echo $active_products_not_attch; } ?></h1>
					<p>Active products but not belong Any User</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="./products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-3 col-6">

			<div class="small-box bg-info">
				<div class="inner">
					<h1><?php
					 if(isset($all_active_total_products_count)){ echo $all_active_total_products_count[0]['total']; } ?></h1>
					<p>All active attached products counts</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="./users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-6">

			<div class="small-box bg-warning">
				<div class="inner">
					<h1><?php
					 if(isset($summarize_prices_for_all)){ echo '€ '.$summarize_prices_for_all[0]['total']; } ?> </h1>
					<p>Attached products Summarized price</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<a href="./products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>


	<h1>Active Products price for each User</h1>

	 <?php 
  	 	$jsonData = json_decode(file_get_contents('http://api.exchangeratesapi.io/v1/latest?access_key=edf3af0f450b6a03976830cd3dd02c87'));
  	  ?>
  	  <P> Today USD price : <?php echo $jsonData->rates->USD;  ?></P>
  	  <P> Today RON price : <?php echo $jsonData->rates->RON;  ?></P>
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">ID</th>
	      <th scope="col">Name</th>
	      <th scope="col">(€) Amount </th>
	      <th scope="col">($) Amount </th>
	      <th scope="col">(lei) Amount </th>

	    </tr>
	  </thead>
	  <tbody>

	  	 <?php if(!empty($summarize_price_for_user)){ ?>

	  	 	<?php foreach($summarize_price_for_user as $user){ ?>
	  	 		<tr>
	  	 		<td><?php echo $user['id']; ?></td>
	  	 		<td><?php echo $user['name']; ?></td>
	  	 		<td><?php echo '€ '. $user['total'] ?></td>
	  	 		<td><?php echo '$ '. ($user['total'] * $jsonData->rates->USD); ?></td>
	  	 		<td><?php echo 'lei '.($user['total'] *  $jsonData->rates->RON) ?></td>
	  	 		</tr>

	  	 <?php 
	  		} 
 	  	  } 

	  	 ?>

	  </tbody>
</table>


</div>
<!-- /Content area -->