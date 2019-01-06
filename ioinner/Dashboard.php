<div class="page-header">
<h3 class="page-title">
<span class="page-title-icon bg-gradient-primary text-white mr-2">
<i class="mdi mdi-home"></i>                 
</span>
Dashboard
</h3>
<nav aria-label="breadcrumb">
<ul class="breadcrumb">
<li class="breadcrumb-item active" aria-current="page">
<span></span>Overview
<i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
</li>
</ul>
</nav>
</div>
<div class="row">
<div class="col-md-4 stretch-card grid-margin">
<div class="card bg-gradient-danger card-img-holder text-white">
<div class="card-body">
<img src="<?=SYS_PATH?>public/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
<h4 class="font-weight-normal mb-3">Enrolled Students
<i class="mdi mdi-chart-line mdi-24px float-right"></i>
</h4>
<h2 class="mb-5"><?=count(getUserGroup(4466,1,$user_data['school_id']))?></h2>
<h6 class="card-text"><?=getEnrollChange( count(getUserGroup(4466, 2, $user_data['school_id'])), count(getUserGroup(4466, 3, $user_data['school_id'])) )?></h6>
</div>
</div>
</div>
<div class="col-md-4 stretch-card grid-margin">
<div class="card bg-gradient-info card-img-holder text-white">
<div class="card-body">
<img src="<?=SYS_PATH?>public/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
<h4 class="font-weight-normal mb-3">School Teachers
<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
</h4>
<h2 class="mb-5">AVR 6,334</h2>
<h6 class="card-text">Decreased by 1.005%</h6>
</div>
</div>
</div>
<div class="col-md-4 stretch-card grid-margin">
<div class="card bg-gradient-success card-img-holder text-white">
<div class="card-body">
<img src="<?=SYS_PATH?>public/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
<h4 class="font-weight-normal mb-3">On Transit now
<i class="mdi mdi-diamond mdi-24px float-right"></i>
</h4>
<h2 class="mb-5">Count 7,041</h2>
<h6 class="card-text">Approx. time 1hr 17min</h6>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-7 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<div class="clearfix">
<h4 class="card-title float-left">Deliveries(volumetric weight) VS Value(KES)</h4>
<div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>                                     
</div>
<canvas id="visit-sale-chart" class="mt-4"></canvas>
</div>
</div>
</div>
<div class="col-md-5 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Common trends</h4>
<canvas id="traffic-chart"></canvas>
<div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>                                                      
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 grid-margin">
<div class="card">
<div class="card-body">
<h4 class="card-title">Recent Recorded Deliveries</h4>
<div class="table-responsive">
<table class="table">
<thead>
<tr>
    <th>
    Shipper
    </th>
    <th>
    Receiver
    </th>
    <th>
    Status
    </th>
    <th>
    Last Update
    </th>
    <th>
    Tracking NO
    </th>
</tr>
</thead>
<tbody>
<tr>
    <td>
    <img src="<?=SYS_PATH?>public/images/faces/face1.jpg" class="mr-2" alt="image">
    David Grey
    </td>
    <td>
    Idd juma J
    </td>
    <td>
    <label class="badge badge-gradient-success">DONE</label>
    </td>
    <td>
    Dec 5, 2018
    </td>
    <td>
    WD-12345
    </td>
</tr>
<tr>
    <td>
    <img src="<?=SYS_PATH?>public/images/faces/face2.jpg" class="mr-2" alt="image">
    Stella Johnson
    </td>
    <td>
    Irene Kimberley
    </td>
    <td>
    <label class="badge badge-gradient-warning">PROGRESS</label>
    </td>
    <td>
    Nov 12, 2018
    </td>
    <td>
    WD-12346
    </td>
</tr>
<tr>
    <td>
    <img src="<?=SYS_PATH?>public/images/faces/face2.jpg" class="mr-2" alt="image">
    Marina Michel
    </td>
    <td>
    Karimi Ian
    </td>
    <td>
    <label class="badge badge-gradient-info">IN TRANSIT</label>
    </td>
    <td>
    Dec 1, 2018
    </td>
    <td>
    WD-12347
    </td>
</tr>
<tr>
    <td>
    <img src="<?=SYS_PATH?>public/images/faces/face2.jpg" class="mr-2" alt="image">
    John Doe
    </td>
    <td>
    Wafula Joye
    </td>
    <td>
    <label class="badge badge-gradient-danger">REJECTED</label>
    </td>
    <td>
    Dec 3, 2017
    </td>
    <td>
    WD-12348
    </td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>