<?php
session_start();
if (!isset($_POST['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
}
if (isset($_SESSION['usersid'])) {
    header('LOCATION:index.php');
} else {
    function main()
    {
        include "config.php";
?>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <style>
            #education_aid_apply .control-label {
                color: #3d51b9;
                font-weight: 600;
            }

            #previous_sponsor_details {
                display: none;
            }

            #rent_house_details {
                display: none;
            }

            #own_house_details {
                display: none;
            }

            @media (max-width: 767px) {

                .mobile-mb,
                .row.mobile-mb {
                    margin-bottom: 20px;
                }

                form .row {
                    margin-bottom: 0;
                }

                .mobile-width {
                    width: 150px;
                }
            }
        </style>

        <body>
            <div class="container">
                    <!-- page title -->
                    <header id="page-header">
                        <h1>Educational Aid</h1>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Add Educational Aid</li>
                            <!-- <li class="text-danger"><b>Note : </b>Applications for  academic year 2022-23 are closed.</li> -->
                        </ol>
                    </header>

                    <div id="content">
                        <div id="panel-1" class="panel panel-default">
                            <div class="panel-heading">
                                <span class="title elipsis">
                                    <strong>APPLICATION FORM FOR EDUCATIONAL AID</strong> <!-- panel title -->
                                </span>
                                <!-- /right options -->
                            </div>
                            <!-- panel content -->
                            <div class="panel-body">
                                <form id="targets" name="targets" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <div class="row">
                                            <div class="form-group">
                                                <!-- <div class="col-md-6 col-sm-6 mobile-mb">
                                                <label class="required control-label">Application No. </label>
                                                <input type="text" name="application_no" class="form-control" required>
                                            </div>-->
                                                <div class="col-md-12 col-sm-12">
                                                    <label class="control-label required">Academic Year</label>
                                                    <div class=" ">
                                                        <select class="form-control" name="year" required>
                                                            <option value="">Select Year</option>
                                                            <?php
                                                            $year = 2013;
                                                            $month = date('m');
                                                            if ($month >= 5) {
                                                                $currentYear = date('Y');
                                                                $length = $currentYear - $year;
                                                                $i = 1;
                                                                while ($i < $length + 2) {
                                                                    $yearnext = $currentYear + 1;
                                                                    $selectedOption = $i == 1 ? "selected" : '';
                                                            ?>
                                                                    <option <?php echo $selectedOption; ?> value="<?php echo $currentYear . "-" . $yearnext;  ?>"><?php echo $currentYear . "-" . $yearnext;  ?></option>
                                                                <?php
                                                                    if($i === 1) break;
                                                                    $i = $i + 1;
                                                                    $currentYear = $yearnext - 2;
                                                                }
                                                            } else {
                                                                $currentYear = date('Y') - 1;
                                                                $length = $currentYear - $year;
                                                                $i = 1;
                                                                while ($i < $length + 2) {
                                                                    $yearnext = $currentYear + 1;
                                                                    $selectedOption = $i == 1 ? "selected" : '';
                                                                ?>
                                                                    <option <?php echo $selectedOption; ?> value="<?php echo $currentYear . "-" . $yearnext;  ?>"><?php echo $currentYear . "-" . $yearnext;  ?></option>
                                                            <?php
                                                                    if($i === 1) break;
                                                                    $i = $i + 1;
                                                                    $currentYear = $yearnext - 2;
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 mobile-mb">
                                                    <label class="required control-label">Name of the Student </label>
                                                    <input type="text" name="name" id="name" class="form-control" value="" required>
                                                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <label class="required control-label">Date of Birth </label>
                                                    <input type="text" id="dob" name="dob" class="form-control datepicker" data-date-end-date="0d" data-format="dd-mm-yyyy" max="<?php echo date("Y-m-d"); ?>" data-lang="en" data-RTL="false" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 mobile-mb">
                                                    <label class="required control-label">Institution Type:</label>
                                                    <select class="form-control" name="institution_type" id="institution_type_list_dropdown" onchange="institutionType()" required>
                                                        <option value="">Select Institution Type</option>
                                                        <option value="1">School</option>
                                                        <option value="2">College</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label required">School (or) College :</label>
                                                    <select class="form-control" name="clge_ref" id="scholl_name_list_dropdown1" onchange="institutionClassType()" required>
                                                        <option value="">Select School (or) College </option>
                                                    </select>
                                                    <button type="button" class="margin-top-10 btn btn-danger btn-xs btn-default btn-quick" data-toggle="modal" data-target="#myModal" title="Add Institution" disabled id="add_institution">Add Institution</button>
                                                </div>
                                            </div>

                                            <!--div class="col-md-3">
                                            </?php
                                            $scl_label = "SELECT * FROM arj_level_tbl WHERE level_id='1' and level_code='class_room_list'" ;
                                            $result_1 = $conn->query($scl_label);
                                            while($res_1 = $result_1->fetch_assoc()) {
                                                ?>
                                                <label class="control-label"></?php echo $res_1['level_name'];?></label>
                                                </?php
                                            }
                                            ?>
                                            <select class="form-control" name="class_name" id="class_name_list_dropdown1">
                                                </?php
                                                $scl = "SELECT * FROM arj_custom_tbl WHERE page='2' and code='class_room_list' and level='1' ORDER BY list_order ASC" ;
                                                $result = $conn->query($scl);
                                                while($res = $result->fetch_assoc()) {
                                                    ?>
                                                    <option value="</?php echo $res['id'];?>" ></?php echo $res['value'];?></option>
                                                    </?php
                                                }
                                                ?>
                                            </select>
                                            <button type="button" class="btn btn-danger btn-xs btn-default btn-quick" data-toggle="modal" data-target="#myModal" title="Add Class">Add Class</button>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="spec_ajax_rsp_blk_1"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <div id="spec_ajax_rsp_blk_2"></div>
                                            </div>
                                            <div class="col-md-1">
                                                <div id="spec_ajax_rsp_blk_3"></div>
                                            </div-->

                                            <div class="col-sm-6 margin-top-10">
                                                <?php
                                                echo '<label class="required control-label">Class (or) Degree  :</label>
                                                <div id="class_name_list_dropdown">
                                                <select class="form-control" name="class_name" id="class_name" required>
                                                    <option disabled selected>Select Class (or) Degree </option>';


                                                ?>
                                                    </select>
                                                </div>
                                                <button type="button" class="margin-top-10 btn btn-danger btn-xs btn-default btn-quick" data-toggle="modal" data-target="#myModalClass" id="check_type" disabled title="Add Class">Add Class</button>
                                            </div>
                                            <div class="col-sm-6 margin-top-10">
                                                <label class="control-label">Specialization </label>
                                                <input type="text" name="specialization" maxlength="30" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 mobile-mb">
                                                    <label class="required control-label">Contact No </label>
                                                    <input type="text" name="phone" maxlength="10" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 col-sm-6 mobile-mb">
                                                    <label class=" control-label">Alternative Mobile </label>
                                                    <input type="nunmber" name="alternate_mobile" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 mobile-mb">
                                                    <label class="required control-label">Nationality </label>
                                                    <input type="text" name="nation" class="form-control" value="Indian" required>
                                                </div>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <label class="required control-label">Gender </label><br />
                                                    <label style="margin-right:15px;"><input type="radio" name="gender" checked value="Male"> Male</label>
                                                    <label style="margin-right:15px;"><input type="radio" name="gender" value="Female"> Female</label>
                                                    <label><input type="radio" name="gender" value="Transgender"> Transgender</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 ">
                                                <div class="form-group mobile-mb">
                                                    <label class="required control-label">Present Address </label>
                                                    <textarea rows="2" name="temp_addr" required></textarea>
                                                </div>
                                                <div class="form-group mobile-mb">
                                                    <label class="required control-label">Country </label>
                                                    <select name="temp_country" class="form-control" onchange="stateSelection(this.value)" required>
                                                        <?php
                                                        $sql = "SELECT * FROM countries";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>" <?php if ($row['name'] == 'India') {
                                                                                                                                        echo 'selected';
                                                                                                                                    } ?>><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mobile-mb">
                                                    <label class="required control-label">State </label>
                                                    <select name="temp_state" class="form-control" onchange="getCities(this.value);" id="states_dropdown_list" required>
                                                        <?php
                                                        $sql = "SELECT * FROM states WHERE country_id = '101' ";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>" <?php if ($row['name'] == 'Tamil Nadu') {
                                                                                                                                        echo 'selected';
                                                                                                                                    } ?>><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mobile-mb">
                                                    <label class="required control-label">City </label>
                                                    <select name="temp_city" class="form-control" id="cities_dropdown_list" required>
                                                        <option value="">Select City</option>
                                                        <?php
                                                        $sql = "SELECT * FROM cities WHERE state_id = '35' ";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mobile-mb">
                                                    <label class="required control-label">Zipcode </label>
                                                    <input type="text" name="temp_zipcode" class="form-control" required="" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><span class="required">Permanent Address</span> </label>
                                                    <textarea rows="2" name="per_addr" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required control-label">Country </label>
                                                    <select name="per_country" class="form-control" onchange="stateSelectionPermanant(this.value)" required>
                                                        <?php
                                                        $sql = "SELECT * FROM countries";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>" <?php if ($row['name'] == 'India') {
                                                                                                                                        echo 'selected';
                                                                                                                                    } ?>><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required control-label">State </label>
                                                    <select name="per_state" class="form-control" onchange="getCitiesPermanant(this.value);" id="states_dropdown_list_permanant" required>
                                                        <?php
                                                        $sql = "SELECT * FROM states WHERE country_id = '101' ";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>" <?php if ($row['name'] == 'Tamil Nadu') {
                                                                                                                                        echo 'selected';
                                                                                                                                    } ?>><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required control-label">City </label>
                                                    <select name="per_city" class="form-control" id="cities_dropdown_list_permanant" required>
                                                        <option value="">Select City</option>
                                                        <?php
                                                        $sql = "SELECT * FROM cities WHERE state_id = '35' ";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>~<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required control-label">Zipcode </label>
                                                    <input type="text" name="per_zipcode" class="form-control" required="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="required control-label">Family Member Details</label>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Relationship</th>
                                                                <th>Age</th>
                                                                <th>Education</th>
                                                                <th>Occupation</th>
                                                                <th>Description</th>
                                                                <th></th>
                                                            </thead>
                                                            <tbody id="moreFamilyMembers">
                                                                <tr>
                                                                    <td><input type="text" class="form-control mobile-width" name="fm_name[]" required></td>
                                                                    <td>
                                                                        <select class="form-control mobile-width" name="fm_relation[]" required>
                                                                            <option Selected disabled>Select</option>
                                                                            <option value="Mother">Mother</option>
                                                                            <option value="Father">Father</option>
                                                                            <option value="Brother">Brother</option>
                                                                            <option value="Sister">Sister</option>
                                                                            <option value="Uncle">Uncle</option>
                                                                            <option value="Aunty">Aunty</option>
                                                                            <option value="Grandfather">Grandfather</option>
                                                                            <option value="Grandmother">Grandmother</option>
                                                                            <option value="Others">Others</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" class="form-control mobile-width" name="fm_age[]" required></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="fm_qualification[]" required></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="fm_occupation[]" required></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="fm_description[]" required></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="button" id="addMoreFamilyMembers" class="btn btn-sm btn-danger margin-top-20 margin-right-10"><i class="glyphicon glyphicon-plus"></i> Add More</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class=" control-label">Is there any Physically Challenged member in your family? If yes, specify ## </label>
                                                    <textarea rows="4" name="fm_phy_challenged"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class=" control-label">Is anyone suffering / suffered from any major illness? If yes, specify (e.g. Heart, Kidney, Liver, Brain etc.):</label>
                                                    <textarea rows="4" name="fm_suffering"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="required control-label">Source of Income</label>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <th>Employer Name</th>
                                                                <th>Monthly income</th>
                                                                <th>Occupation / Place of working</th>
                                                                <th>Employer Signature</th>
                                                                <th>Contact No.</th>
                                                                <th></th>
                                                            </thead>
                                                            <tbody id="moreIncome">
                                                                <tr>
                                                                    <td><input type="text" class="form-control mobile-width" name="si_sname[]" required></td>
                                                                    <td><input type="number" class="form-control mobile-width" name="si_month_income[]" required></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="si_occupation[]" required></td>
                                                                    <td><input type="text" class="form-control" name="si_signature[]" required></td>
                                                                    <td><input type="number" class="form-control" name="si_contact[]" required></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="button" id="addMoreIncome" class="btn btn-sm btn-danger margin-top-20 margin-right-10"><i class="glyphicon glyphicon-plus"></i> Add More</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6">
                                                    <label class="required control-label">Total income per month </label>
                                                    <input type="number" name="total_income" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class=" control-label">Major financial commitments, if any please specify (e.g.Loans, Educational fee, Insurance etc.) :</label>
                                                    <textarea rows="4" name="financial_commit"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class=" control-label margin-bottom-10">Details of Assets</label>
                                                    <div class="row mobile-mb">
                                                        <div class="col-sm-3">House</div>
                                                        <div class="col-sm-3 Rented"><label><input type="checkbox" name="house[]" id="Rented" value="Rented"> Rented</label></div>
                                                        <div class="col-sm-3 Owned"><label><input type="checkbox" name="house[]" id="Owned" value="Owned"> Owned</label></div>
                                                        <div class="col-sm-3 Rented"><label><input type="checkbox" name="house[]" id="Leased" value="Leased"> Leased</label></div>
                                                    </div>
                                                    <div id="own_house_details" style="margin-bottom: 20px;">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label class="control-label">Provide the below details about own house</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-4 col-sm-4 mobile-mb">
                                                                        <label class=" control-label">Total area </label>
                                                                        <input type="text" name="own_area" maxlength="10" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-4 mobile-mb">
                                                                        <label class=" control-label">Market value </label>
                                                                        <input type="text" name="own_market_value" class="form-control" value="">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-4 ">
                                                                        <label class=" control-label">Years of living </label><br />
                                                                        <input type="number" name="own_years" maxlength="10" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="rent_house_details">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label class="control-label">Provide the below details about Rented (or) Leased House</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <th>Landlord Name</th>
                                                                                <th>Monthly Rent /
                                                                                    Leased Value</th>
                                                                                <th>Years of Stay
                                                                                    / Agreement</th>
                                                                                <th>Landlord Signature</th>
                                                                                <th>Contact No</th>
                                                                            </thead>
                                                                            <tbody id="">
                                                                                <tr>
                                                                                    <td><input type="text" class="form-control mobile-width" name="rent_name"></td>
                                                                                    <td><input type="text" class="form-control mobile-width" name="rent_value"></td>
                                                                                    <td><input type="text" class="form-control mobile-width" name="rent_years"></td>
                                                                                    <td><input type="text" class="form-control mobile-width" name="rent_signature"></td>
                                                                                    <td><input type="number" class="form-control mobile-width" name="rent_contact" maxlength="12"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mobile-mb">
                                                        <div class="col-sm-3">Vehicles</div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="vehicles[]" value="Two Wheeler"> Two Wheeler</label></div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="vehicles[]" value="Bicycle"> Bicycle</label></div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="vehicles[]" value="Others"> Others</label></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">Home Appliances</div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="home_appliance[]" value="TV/DVD Player"> TV/DVD Player</label></div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="home_appliance[]" value="Washing Machine"> Washing Machine</label></div>
                                                        <div class="col-sm-3"><label><input type="checkbox" name="home_appliance[]" value="Refrigerator"> Refrigerator</label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mobile-mb">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">Previous Sponsorship</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="margin-right-10"><input type="radio" name="pre_sponcer" value="Yes"> Yes</label>
                                                            <label><input type="radio" name="pre_sponcer" value="No" checked> No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="previous_sponsor_details">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Name and address of the Organization / Trust</label>
                                                        <input type="text" name="organisation" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Present status</label>
                                                        <div class="col-md-12">
                                                            <label><input type="radio" name="present_status" value="Still Active"> Still Active</label>
                                                            <label><input type="radio" name="present_status" value="Completed"> Completed</label>
                                                            <label><input type="radio" name="present_status" value="Rejected"> Rejected</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class=" control-label">If rejected, please specify the reason:</label>
                                                        <textarea rows="4" name="reject_reson"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4><u>References</u></h4>

                                        <!--div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <label class="control-label">School (or) College Reference:</label>
                                                            <select class="form-control" name="clge_ref" id="scholl_name_list_dropdown1">
                                                                </?php
                                                                $scl = "SELECT * FROM tbl_school_type ORDER BY school_name ASC" ;
                                                                $result = $conn->query($scl);
                                                                while($res = $result->fetch_assoc()) {
                                                                    ?>
                                                                    <option value="</?php echo $res['school_name'];?>" ></?php echo $res['school_name'];?></option>
                                                                    </?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <button type="button" class="btn btn-danger btn-xs btn-default btn-quick" data-toggle="modal" data-target="#myModal" title="Add New School"><i class="fa fa-edit"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <label class="control-label">School (or) College Name and Address:</label>
                                                            <input type="text" name="sc_addr" class="form-control">
                                                        </div>
                                                    </div>
                                                </div-->
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">School / College Name and Address:</label>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <th>Sl.No</th>
                                                                <th>Name</th>
                                                                <th>Designation</th>
                                                                <th>Signature</th>
                                                                <th>Contact</th>
                                                            </thead>
                                                            <tbody id="moreIncome">
                                                                <tr>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_sno[]" value="1" readonly></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_name[]"></td>
                                                                    <td>
                                                                        <select class="form-control mobile-width" name="ref_designation[]">
                                                                            <option Selected disabled>Select</option>
                                                                            <option value="Principal">Principal</option>
                                                                            <option value="Vice Principal">Vice Principal</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_signature[]"></td>
                                                                    <td><input type="text" class="form-control mobile-width" maxlength="10" name="ref_contact[]"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_sno[]" value="2" readonly></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_name[]"></td>
                                                                    <td>
                                                                        <select class="form-control mobile-width" name="ref_designation[]">
                                                                            <option Selected disabled>Select</option>
                                                                            <option value="Class Teacher">Class Teacher </option>
                                                                            <option value="HOD">HOD</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" class="form-control mobile-width" name="ref_signature[]"></td>
                                                                    <td><input type="text" class="form-control mobile-width" maxlength="10" name="ref_contact[]"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">General Reference</label>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Designation</th>
                                                                <th>Signature</th>
                                                                <th>Contact</th>
                                                            </thead>
                                                            <tbody id="moreIncome">
                                                                <tr>
                                                                    <td><input type="text" class="form-control mobile-width" name="gref_name" value=""></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="gref_designation"></td>
                                                                    <td><input type="text" class="form-control mobile-width" name="gref_signature"></td>
                                                                    <td><input type="number" class="form-control mobile-width" name="gref_contact" maxlength="10"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="required control-label">Your Documents</label>
                                                    <p style="font-size:13px;margin-top: 7px; "><span class="text-danger" style="font-size:15px"><b>Note:</b></span> Please upload required files in <b>JPEG</b> and <b>PDF</b> format only. Image size must be less than <b>200 Kb </b>and Other documents up to <b>1.2 MB</b>. If you want to Compress your File <b>Click <a href="https://tinypng.com/" target="_blank">Here</a></b></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Applicant's photo</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file" name="Applicant_photo" required accept="image/jpg,image/jpeg,image/png" onchange="jQuery(this).next('input').val(this.value);return img();">
                                                            <input type="text" class="form-control" id="Applicant_photo" name="Applicant_photo1" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Age Proof</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file1" name="age_proof_doc" required accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img1();">
                                                            <input type="text" class="form-control" id="age_proof_doc" name="age_proof_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Address Proof</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file2" name="add_proof_doc" required accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img2();">
                                                            <input type="text" class="form-control" id="add_proof_doc" name="add_proof_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Family Photo</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file3" name="fam_proof_doc" required accept="image/jpg,image/jpeg,image/png" onchange="jQuery(this).next('input').val(this.value);img3();">
                                                            <input type="text" class="form-control" id="fam_proof_doc" name="fam_proof_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Income Proof</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file4" name="in_proof_doc" required accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img4();">
                                                            <input type="text" class="form-control" id="in_proof_doc" name="in_proof_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Mark Sheet</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file5" name="mark_sheet_doc" required accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img5();">
                                                            <input type="text" class="form-control" id="mark_sheet_doc" name="mark_sheet_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="required control-label">Rental Letter</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file6" name="rental_letter_doc" required accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img6();">
                                                            <input type="text" class="form-control" id="rental_letter_doc" name="rental_letter_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class=" control-label">Medical details, if any</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file7" name="medical_doc" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img7();">
                                                            <input type="text" class="form-control" id="medical_doc" name="medical_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class=" control-label">Others, if any</label>
                                                        <div class="fancy-file-upload fancy-file-primary">
                                                            <i class="fa fa-upload"></i>
                                                            <input type="file" class="form-control valid" id="file8" name="other_doc" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png" onchange="jQuery(this).next('input').val(this.value);img8();">
                                                            <input type="text" class="form-control" id="other_doc" name="other_docs" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class=" control-label"> Describe about your family background and state the reasons for applying educational scholarship..</label>
                                                    <textarea rows="4" name="apply_reason" required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="control-label">Declaration :</label>
                                                    <label><input type="checkbox" name="check_status" id="check_status"> I / We hereby declare that all the information furnished above is / are true to the best of my / our knowledge. If any information is found incorrect, my / our application for Educational Aid from Punyah Foundation can be rejected.</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-3d btn-teal btn-xlg btn-block margin-top-30" name="add_educationss">
                                                    SAVE APPLICATION
                                                </button>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--ADD NEW SCHOOL Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="add_school_modal_close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">ADD INSTITUTION NAME</h4>
                            </div>
                            <div class="modal-body">

                                <form class="well">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label class="control-label">Institution Name:</label>
                                                <input type="text" name="school_name" id="school_name" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">Institution Type:</label>
                                                <select class="form-control inst_type" name="inst_type" id="inst_type">
                                                    <option value="">Select Type</option>
                                                    <option value="1">School</option>
                                                    <option value="2">College</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="margin-top-10">
                                        <button type="button" onclick="add_school()" class="btn btn-sm btn-primary">Submit</button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- ADD NEW CLASS Modal -->
                <div class="modal fade" id="myModalClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="add_class_modal_close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">ADD CLASS NAME</h4>
                            </div>
                            <div class="modal-body">
                                <form class="well">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <label class="required control-label">Class Name:</label>
                                                <input type="text" name="class_name_new" id="class_name_new" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="required control-label">Class Type:</label>
                                                <select class="form-control class_name_type" name="class_name_type" id="class_name_type">
                                                    <option value="">Select Type</option>
                                                    <option value="1">School</option>
                                                    <option value="2">College</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="margin-top-10">
                                        <button type="button" id="add_class_submit" class="btn btn-sm btn-primary">Submit</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
        </body>
<?php

        if (isset($_POST['add_educationss'])) {
            //Generate application number
            var_dump("hello");
            $acadamic_year = addslashes($_POST['year']);
            
            function applicationNo($acadamic_year,$conn){
                $app_year = substr($acadamic_year, 2, 3) . substr($acadamic_year, 7, 2);
                $max_no = mysqli_query($conn, "SELECT count(*) as counter FROM `tbl_education` WHERE year='$acadamic_year'");
                $res_maxno = mysqli_fetch_array($max_no);
                $number = $res_maxno['counter'] + 1;
                $app_no = $app_year . "/" . $number;
                return $app_no;
            }

            // $app_year = substr($acadamic_year, 2, 3) . substr($acadamic_year, 7, 2);
            // $max_no = mysqli_query($conn, "SELECT max(application_no) AS max_no FROM `tbl_education` WHERE year='$acadamic_year'");
            // $res_maxno = mysqli_fetch_array($max_no);
            // $number = $res_maxno['max_no'];
            // $app_no1 = substr($number, strpos($number, "/") + 1);
            // $app_no = $app_no1 + 1;

            // $application_no = $app_year . "/" . $app_no;
            // $check_num = mysqli_query($conn, "SELECT application_no  FROM `tbl_education` WHERE application_no='$application_no'");
            // $res_check = mysqli_fetch_array($check_num);
            // if($check_num->num_rows > 0){
            //     $application = $res_check['application_no'];
            //     $appYear = substr($application,0,5);
            //     $like =  '%'.$appYear.'%';
            //     $max_no = mysqli_query($conn, "SELECT max(application_no) AS max_no FROM `tbl_education` WHERE application_no like '$like'");
            //     $res_maxno = mysqli_fetch_array($max_no);
            //     $number = $res_maxno['max_no'];
            //     $app_no1 = substr($number, strpos($number, "/") + 1);
            //     $app_no = $app_no1 + 1;
    
            //     $application_no = $appYear . "/" . $app_no;
            // }


            $name = addslashes($_POST['name']);
            $dob = addslashes($_POST['dob']);
            $scl_name = addslashes($_POST['scl_name']);
            $course = addslashes($_POST['course']);
            $phone = addslashes($_POST['phone']);
            $alternate_mobile = addslashes($_POST['alternate_mobile']);
            $gender = addslashes($_POST['gender']);
            $nation = addslashes($_POST['nation']);

            $temp_addr = addslashes($_POST['temp_addr']);
            $temp_country = addslashes($_POST['temp_country']);
            $temp_state = addslashes($_POST['temp_state']);
            $temp_city = addslashes($_POST['temp_city']);
            $temp_zipcode = addslashes($_POST['temp_zipcode']);

            $per_addr = addslashes($_POST['per_addr']);
            $per_country = addslashes($_POST['per_country']);
            $per_state = addslashes($_POST['per_state']);
            $per_city = addslashes($_POST['per_city']);
            $per_zipcode = addslashes($_POST['per_zipcode']);
            $csrf = addslashes($_POST['csrf_token']);


            $fm_name = addslashes(implode(",", $_POST['fm_name']));
            $fm_relation = addslashes(implode(",", $_POST['fm_relation']));
            $fm_age = addslashes(implode(",", $_POST['fm_age']));
            $fm_qualification = addslashes(implode(",", $_POST['fm_qualification']));
            $fm_occupation = addslashes(implode(",", $_POST['fm_occupation']));
            $fm_description = addslashes(implode(",", $_POST['fm_description']));

            $fm_phy_challenged = addslashes($_POST['fm_phy_challenged']);
            $fm_suffering = addslashes($_POST['fm_suffering']);

            $si_sname = addslashes(implode(",", $_POST['si_sname']));
            $si_relation = '';
            $si_age = '';
            $si_month_income = addslashes(implode(",", $_POST['si_month_income']));
            $si_occupation = addslashes(implode(",", $_POST['si_occupation']));
            $si_signature = addslashes(implode(",", $_POST['si_signature']));
            $si_contact = addslashes(implode(",", $_POST['si_contact']));


            $total_income = addslashes($_POST['total_income']);
            $financial_commit = addslashes($_POST['financial_commit']);
            $house = addslashes(implode(",", $_POST['house']));
            if (in_array('Rented', $_POST['house']) || in_array('Leased', $_POST['house'])) {
                $rent_name = addslashes($_POST['rent_name']);
                $rent_value = addslashes($_POST['rent_value']);
                $rent_years = addslashes($_POST['rent_years']);
                $rent_signature = addslashes($_POST['rent_signature']);
                $rent_contact = addslashes($_POST['rent_contact']);
            } else {
                $rent_name = '';
                $rent_value = '';
                $rent_years = '';
                $rent_signature = '';
                $rent_contact = '';
            }

            if (in_array('Owned', $_POST['house'])) {
                $own_area = addslashes($_POST['own_area']);
                $own_market_value = addslashes($_POST['own_market_value']);
                $own_years = addslashes($_POST['own_years']);
            } else {
                $own_area = '';
                $own_market_value = '';
                $own_years = '';
            }

            $vehicles = addslashes(implode(",", $_POST['vehicles']));
            $home_appliance = addslashes(implode(",", $_POST['home_appliance']));
            $pre_sponcer = addslashes($_POST['pre_sponcer']);
            $organisation = addslashes($_POST['organisation']);
            $present_status = addslashes($_POST['present_status']);
            $reject_reson = addslashes($_POST['reject_reson']);
            $institution_type = addslashes($_POST['institution_type']);
            $clge_ref = addslashes($_POST['clge_ref']);
            $sc_addr = addslashes($_POST['sc_addr']);
            $ref_sno = addslashes(implode(",", $_POST['ref_sno']));
            $ref_name = addslashes(implode(",", $_POST['ref_name']));
            $ref_designation = addslashes(implode(",", $_POST['ref_designation']));
            $ref_signature = addslashes(implode(",", $_POST['ref_signature']));
            $ref_contact = addslashes(implode(",", $_POST['ref_contact']));

            $gref_name = addslashes($_POST['gref_name']);
            $gref_designation = addslashes($_POST['gref_designation']);
            $gref_signature = addslashes($_POST['gref_signature']);
            $gref_contact = addslashes($_POST['gref_contact']);

            $class_name = addslashes($_POST['class_name']);
            $specialization = addslashes($_POST['specialization']);

            $Applicant_photo = $_FILES['Applicant_photo']['name'];
            $age_proof_doc = $_FILES['age_proof_doc']['name'];
            $add_proof_doc = $_FILES['add_proof_doc']['name'];
            $fam_proof_doc = $_FILES['fam_proof_doc']['name'];
            $in_proof_doc = $_FILES['in_proof_doc']['name'];
            $mark_sheet_doc = $_FILES['mark_sheet_doc']['name'];
            $rental_letter_doc = $_FILES['rental_letter_doc']['name'];

            $files = [
                "Applicant_photo" => $Applicant_photo,
                "Age_Proof" => $age_proof_doc,
                "Address_proof" => $add_proof_doc,
                "Family_proof" => $fam_proof_doc,
                "Income_proof" => $in_proof_doc,
                "Mark_sheet" => $mark_sheet_doc,
                "Rental_letter" => $rental_letter_doc,
            ];

            $allowed = array('pdf', 'jpg', 'jpeg', 'doc', 'docx', 'png');
            foreach ($files as $k => $v) {
                $ext = pathinfo($v, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {

                    echo "<script>alert('.$k. Extension Not Allowed');</script>";
                    return false;
                }
            }

            if ($_FILES['medical_doc']['name']) {
                $medical_doc = $_FILES['medical_doc']['name'];
                $path7 = dirname(__DIR__) . "/upload/verification_doc/" . $medical_doc;
                $move7 = move_uploaded_file($_FILES['medical_doc']['tmp_name'], $path7);
            } else {
                $medical_doc = '';
            }
            if ($_FILES['other_doc']['name']) {
                $other_doc = $_FILES['medical_doc']['name'];
                $path8 = dirname(__DIR__) . "/upload/verification_doc/" . $other_doc;
                $move8 = move_uploaded_file($_FILES['other_doc']['tmp_name'], $path8);
            } else {
                $other_doc = '';
            }

            $apply_reason = addslashes($_POST['apply_reason']);



            $temp_id = 0;
            $date = date("Y-m-d");
            if ($_SESSION['csrf_token'] == $csrf) {
                $sql = "insert into tbl_education(user_id,year,application_no,name,dob,scl_name,course,gender,nation,phone,alternate_mobile,temp_addr,temp_country,temp_state,temp_city,temp_zipcode,per_addr,per_country,per_state,per_city,per_zipcode,fm_name,fm_relation,fm_age,fm_qualification,fm_occupation,fm_description,fm_phy_challenged,fm_suffering,si_sname,si_age,si_relation,si_month_income,si_occupation,si_signature,si_contact,total_income,financial_commit,house,own_area,own_market_value,own_years,rent_name,rent_value,rent_years,rent_signature,rent_contact,vehicles,home_appliance,pre_sponcer,organisation,present_status,reject_reson,institution_type,clge_ref,sc_addr,ref_sno,ref_name,ref_designation,ref_signature,ref_contact,gref_name,gref_designation,gref_signature,gref_contact,status,Applicant_photo_stu,age_proof_doc,add_proof_doc,fam_proof_doc,in_proof_doc,mark_sheet_doc,rental_letter_doc,medical_doc,other_doc,apply_reason, created_date, class_name, specialization,del_status) 
			values('" . $_SESSION['userid'] . "','" . $acadamic_year . "','" . applicationNo($acadamic_year,$conn) . "','" . $name . "','" . $dob . "','" . $scl_name . "','" . $course . "','" . $gender . "','" . $nation . "','" . $phone . "','" . $alternate_mobile . "','" . $temp_addr . "','" . $temp_country . "','" . $temp_state . "','" . $temp_city . "','" . $temp_zipcode . "','" . $per_addr . "','" . $per_country . "','" . $per_state . "','" . $per_city . "','" . $per_zipcode . "','" . $fm_name . "','" . $fm_relation . "','" . $fm_age . "','" . $fm_qualification . "','" . $fm_occupation . "','" . $fm_description . "','" . $fm_phy_challenged . "','" . $fm_suffering . "','" . $si_sname . "','" . $si_age . "','" . $si_relation . "','" . $si_month_income . "','" . $si_occupation . "','" . $si_signature . "','" . $si_contact . "','" . $total_income . "','" . $financial_commit . "','" . $house . "','" . $own_area . "','" . $own_market_value . "','" . $own_years . "','" . $rent_name . "','" . $rent_value . "','" . $rent_years . "','" . $rent_signature . "','" . $rent_contact . "','" . $vehicles . "','" . $home_appliance . "','" . $pre_sponcer . "','" . $organisation . "','" . $present_status . "','" . $reject_reson . "','" . $institution_type . "','" . $clge_ref . "','" . $sc_addr . "','" . $ref_sno . "','" . $ref_name . "','" . $ref_designation . "','" . $ref_signature . "','" . $ref_contact . "','" . $gref_name . "','" . $gref_designation . "','" . $gref_signature . "','" . $gref_contact . "','Applied', '" . $Applicant_photo . "', '" . $age_proof_doc . "', '" . $add_proof_doc . "', '" . $fam_proof_doc . "', '" . $in_proof_doc . "', '" . $mark_sheet_doc . "', '" . $rental_letter_doc . "', '" . $medical_doc . "', '" . $other_doc . "', '" . $apply_reason . "', '" . $date . "', '" . $class_name . "', '" . $specialization . "','0')";

                $path = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$Applicant_photo";
                $path1 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$age_proof_doc";
                $path2 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$add_proof_doc";
                $path3 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$fam_proof_doc";
                $path4 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$in_proof_doc";
                $path5 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$mark_sheet_doc";
                $path6 = $_SERVER["DOCUMENT_ROOT"] . "/upload/verification_doc/$rental_letter_doc";

                $move = move_uploaded_file($_FILES['Applicant_photo']['tmp_name'], $path);
                $move1 = move_uploaded_file($_FILES['age_proof_doc']['tmp_name'], $path1);
                $move2 = move_uploaded_file($_FILES['add_proof_doc']['tmp_name'], $path2);
                $move3 = move_uploaded_file($_FILES['fam_proof_doc']['tmp_name'], $path3);
                $move4 = move_uploaded_file($_FILES['in_proof_doc']['tmp_name'], $path4);
                $move5 = move_uploaded_file($_FILES['mark_sheet_doc']['tmp_name'], $path5);
                $move6 = move_uploaded_file($_FILES['rental_letter_doc']['tmp_name'], $path6);

                if ($conn->query($sql)) {
                    $id = $conn->insert_id;
                    $final = mysqli_query($conn,"SELECT * FROM tbl_education WHERE id=".$id);
                    $finalResult = mysqli_fetch_array($final);
                    $to = 'punyahfoundation@gmail.com';
                    $subject = 'A new student';
                    $msg = '<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Simple Transactional Email</title><style>
 @media only screen and (max-width: 620px) {
table.body h1 {
font-size: 28px !important;
margin-bottom: 10px !important;
}

table.body p,
table.body ul,
table.body ol,
table.body td,
table.body span,
table.body a {
font-size: 16px !important;
}

table.body .wrapper,
table.body .article {
    padding: 10px !important;
}

table.body .content {
padding: 0 !important;
}

table.body .container {
padding: 0 !important;
width: 100% !important;
}

table.body .main {
border-left-width: 0 !important;
border-radius: 0 !important;
border-right-width: 0 !important;
}

table.body .btn table {
width: 100% !important;
}

table.body .btn a {
width: 100% !important;
}

table.body .img-responsive {
height: auto !important;
max-width: 100% !important;
width: auto !important;
}
}
@media all {
.ExternalClass {
width: 100%;
}

.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
line-height: 100%;
}

.apple-link a {
color: inherit !important;
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
text-decoration: none !important;
}

#MessageViewBody a {
color: inherit;
text-decoration: none;
font-size: inherit;
font-family: inherit;
font-weight: inherit;
line-height: inherit;
}

.btn-primary table td:hover {
background-color: #34495e !important;
}
.btn-primary a:hover {
background-color: #34495e !important;
border-color: #34495e !important;
}
}
</style>
</head>
<body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
<table role="presentation"  class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background:#f3eddf !important; " >
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
<tr>
 <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
<tr><img src="https://ci3.googleusercontent.com/proxy/YU9sb_27lUzaLB57tvNZHQs5d6SEXSBizfxEbhPCqDhiYEGW5S0Dwo4JKkaw5W3stdV4T1-GrggV4DmtcjIwuKcM1d3KPRuvhGKLRdOhk_SGylfzP7LmoCv0X_NVXIVtBl9UrRhbAoJY1-bLSy_TmpD3NXriKp4v-ymX3lFqvsfEwWUegiKo-ZCiR_bUypKrnkP52qDL27j9pBWqWQ=s0-d-e1-ft#https://docs.google.com/uc?export=download&amp;id=1pcBfKinLpzbRSIjFGCfq77O1nQaJX8_9&amp;revid=0B69l8gsQzfdvWk5yU3ByYXdZMUlHWlpPWHJZaE4vUGVwRUI4PQ" width="200" height="68" class="CToWUd"></tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hi ,</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><b>New Application Received !!</b></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Application No : ' . $finalResult['application_no'] . '</p>                                   
</table>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><i>Our primary objective is to support the educational aspirations of underprivileged and meritorious children and determined to develop them for a better tomorrow.</i></p><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">If you want to check. <b>Click below</b></p>
<a href="'.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/admin/view-student-profile-information.php?id=' . $id . '" target="_blank" style="border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;">View Application</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
<div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
<tr>
<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">64, Sree Thiruvenkata Nagar, Maniyakarampalayam Road, Ganapathy,
<br>Coimbatore - 641006, Tamilnadu      </br><India class=""></India></span>
</td>
</tr>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
Powered by <a href="http://htmlemail.io" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">Punyah Foundation</a>.
</td>
</tr>
</table>
</div>

</div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
</tr>
</table>
</body>
</html>';

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <punyahfoundation@gmail.com>' . "\r\n";
                    $headers .= 'Cc:Ram80ind@gmail.com' . "\r\n";
                    $headers .= 'Cc:leodrameshbabu@gmail.com' . "\r\n";
                    $headers .= 'Cc:i2u.premg@gmail.com' . "\r\n";
                    // $headers .= 'Cc:sakthivel@kaptastech.in' . "\r\n";

                    //mail($to, $subject, $msg, $headers);
                    echo "<script>alert('Student Details Added Successfully');setTimeout(function(){window.location.href='index.php'},1000)</script>";
                    unset($_SESSION['csrf_token']);
                } else {
                    echo "<script>alert('Error.. Student Details not Added');</script>";
                }
            } else {
                echo "<script>alert('Opps! Some Fields are Missing..Please Resubmit the Form!!')</script>";
            }
        }
    }
    include_once('template.php');
}
?>

<script>
    $(document).ready(function() {
        $("#scholl_name_list_dropdown1").select2();
        $("#class_name").select2();
        $('#cities_dropdown_list').select2();
        $('#cities_dropdown_list_permanant').select2();
        $("input[type=text], textarea").keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });
    });

    function institutionType() {
        document.getElementById('add_institution').removeAttribute('disabled');
        document.getElementById('check_type').removeAttribute('disabled');

        var inst_type = $('#institution_type_list_dropdown').val();
        $(".inst_type option:selected").prop("selected", false);
        $(".inst_type option[value=" + inst_type + "]")
            .prop("selected", true);
        $('.inst_type').attr('disabled', '');

        $(".class_name_type option:selected").prop("selected", false);
        $(".class_name_type option[value=" + inst_type + "]")
            .prop("selected", true);
        $('.class_name_type').attr('disabled', '');

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "ajax.php?type=" + document.getElementById('institution_type_list_dropdown').value, false);
        xmlhttp.send();
        document.getElementById('scholl_name_list_dropdown1').innerHTML = xmlhttp.responseText;
    }

    function institutionClassType() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "ajax.php?ctype=" + document.getElementById('institution_type_list_dropdown').value, false);
        xmlhttp.send();
        document.getElementById('class_name').innerHTML = xmlhttp.responseText;
    }
    var familyCount = 1;
    $("#addMoreFamilyMembers").click(function() {
        $("#moreFamilyMembers").append('<tr id="familyList' + familyCount + '"><td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="fm_name[]" ></td> <td><select class="form-control" name="fm_relation[]"><option Selected disabled>Select</option> <option value="Mother">Mother</option> <option value="Father">Father</option> <option value="Brother">Brother</option> <option value="Sister">Sister</option> <option value="Uncle">Uncle</option> <option value="Aunty">Aunty</option> <option value="Grandfather">Grandfather</option> <option value="Grandmother">Grandmother</option> <option value="Others">Others</option> </select>  </td> <td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="fm_age[]" ></td> <td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="fm_qualification[]" ></td> <td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="fm_occupation[]" ></td><td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control mobile-width" name="fm_description[]"></td><td><i class="fa fa-remove" id="removeFM' + familyCount + '" onclick="removeFamily(' + familyCount + ')"></i></td></tr>');
        familyCount += 1;
    });


    var incomeCount = 1;
    $("#addMoreIncome").click(function() {
        $("#moreIncome").append('<tr id="incomeList' + incomeCount + '"><td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="si_sname[]" ></td> <td><input type="number" class="form-control" name="si_month_income[]" ></td> <td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="si_occupation[]" ></td><td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="si_signature[]" required></td><td><input type="number" class="form-control" name="si_contact[]" required></td><td><i class="fa fa-remove" id="removeFM' + incomeCount + '" onclick="removeIncome(' + incomeCount + ')"></i></td></tr>');
        incomeCount += 1;
    });

    function removeFamily(id) {
        var familyCount = familyCount - 1;
        $("#familyList" + id).remove();
    }

    function removeIncome(id) {
        $("#incomeList" + id).remove();
    }

    $(document).ready(function() {
        $('#targets').submit(function() {
            var error = 0;
            if (!($('#check_status').is(':checked'))) {
                error = 1
                alert("Please Tick the Agree to Terms of Use");
            }
            if (error) {
                return false;
            } else {
                return true;
            }

        });
    });

    function add_school() {
        var url = "process-apply.php";
        var school_name = $("#school_name").val();
        var inst_type = $('#inst_type').val();
        if (school_name != '') {
            var paramData = {
                'act': 'Add_School',
                'school_name': school_name,
                'inst_type': inst_type
            };

            $.ajax({
                type: "POST",
                url: url,
                data: $.param(paramData),
                error: function(e) {
                    alert(e);
                },
                success: function(data) {
                    if (data != '' && data != 'exist') {
                        $('#scholl_name_list_dropdown').html(data);
                        $('#scholl_name_list_dropdown1').html(data);
                        $("#add_school_modal_close").trigger('click');
                    } else if (data == 'exist') {
                        alert("This School Name Already Exit.");
                    }
                }
            });
        } else {
            alert("Please add school name");
            return false;
        }
    }


    //stateSelection//

    function stateSelection(id) {
        var url = "process-apply.php";
        if (id != '') {
            var paramData = {
                'act': 'get_states',
                'id': id
            };

            $.ajax({
                type: "POST",
                url: url,
                data: $.param(paramData),
                error: function(e) {
                    alert(e);
                },
                success: function(data) {
                    $("#states_dropdown_list").html(data);
                }
            });
        } else {
            alert("Please Select a Country");
            return false;
        }
    }

    //CitySelection//

    function getCities(id) {
        var url = "process-apply.php";
        if (id != '') {
            var paramData = {
                'act': 'get_cities',
                'id': id
            };

            $.ajax({
                type: "POST",
                url: url,
                data: $.param(paramData),
                error: function(e) {
                    alert(e);
                },
                success: function(data) {
                    $("#cities_dropdown_list").html(data);
                }
            });
        } else {
            alert("Please Select a Country");
            return false;
        }
    }
    //stateSelection//

    function stateSelectionPermanant(id) {
        var url = "process-apply.php";
        if (id != '') {
            var paramData = {
                'act': 'get_states',
                'id': id
            };

            $.ajax({
                type: "POST",
                url: url,
                data: $.param(paramData),
                error: function(e) {
                    alert(e);
                },
                success: function(data) {
                    $("#states_dropdown_list_permanant").html(data);
                }
            });
        } else {
            alert("Please Select a Country");
            return false;
        }
    }

    //CitySelection//

    function getCitiesPermanant(id) {
        var url = "process-apply.php";
        if (id != '') {
            var paramData = {
                'act': 'get_cities',
                'id': id
            };

            $.ajax({
                type: "POST",
                url: url,
                data: $.param(paramData),
                error: function(e) {
                    alert(e);
                },
                success: function(data) {
                    $("#cities_dropdown_list_permanant").html(data);
                }
            });
        } else {
            alert("Please Select a Country");
            return false;
        }
    }

    $('input:radio[name=pre_sponcer]').change(function() {
        if (this.value == 'Yes') {
            $("#previous_sponsor_details").show();
        } else if (this.value == 'No') {
            $("#previous_sponsor_details").hide();
        }
    });

    $('.Rented').click(function() {
        if ($('#Rented').is(':checked') || $('#Leased').is(':checked')) {
            $("#rent_house_details").show();
        } else {
            $("#rent_house_details").hide();
        }
    });

    $('.Owned').click(function() {
        if ($('#Owned').is(':checked') || $('#Leased').is(':checked')) {
            $("#own_house_details").show();
        } else {
            $("#own_house_details").hide();
        }
    });

    $('#add_class_submit').click(function() {

        var c_name = $('#class_name_new').val();
        var c_type = $('#class_name_type').val();

        if (c_name != '') {
            $.ajax({
                url: "arj_ajx_cust.php?p=addClassModal&c_name=" + c_name + "&c_type=" + c_type,
                success: function(result) {
                    if (result != '' && result != 'exist') {
                        $('#class_name_list_dropdown').html(result);
                        $("#add_class_modal_close").trigger('click');
                    } else if (result == 'exist') {
                        alert("This Class Name Already Exit.");
                    }

                }
            });
        } else {
            alert("Class Name is a required Field");
            return false;
        }
    });

    function img() {

        n = document.getElementById("Applicant_photo").value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file").val("");
            $("#Applicant_photo").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("Applicant_photo").value = z;
        }

    }

    function img1() {

        n = document.getElementById("age_proof_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file1").val("");
            $("#age_proof_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file1").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("age_proof_doc").value = z;
        }

    }

    function img2() {
        n = document.getElementById("add_proof_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file2").val("");
            $("#add_proof_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file2").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("add_proof_doc").value = z;
        }

    }

    function img3() {
        n = document.getElementById("fam_proof_doc").value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file3").val("");
            $("#fam_proof_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file3").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("fam_proof_doc").value = z;
        }

    }

    function img4() {
        n = document.getElementById("in_proof_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file4").val("");
            $("#in_proof_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file4").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("in_proof_doc").value = z;
        }

    }

    function img5() {
        n = document.getElementById("mark_sheet_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file5").val("");
            $("#mark_sheet_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file5").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("mark_sheet_doc").value = z;
        }

    }

    function img6() {
        n = document.getElementById("rental_letter_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file6").val("");
            $("#rental_letter_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file6").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("rental_letter_doc").value = z;
        }

    }

    function img7() {
        n = document.getElementById("medical_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file7").val("");
            $("#medical_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file7").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("medical_doc").value = z;
        }

    }

    function img8() {
        n = document.getElementById("other_doc").value;
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(n)) {
            $("#file8").val("");
            $("#other_doc").val("");
            alert('Invalid file type');
            fileInput.value = '';
            return false;
        } else {
            z = document.getElementById("file8").value.replace(/C:\\fakepath\\/i, '');
            document.getElementById("other_doc").value = z;
        }

    }

    $('#file').change(function(event) {
        var _size = this.files[0].size;
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if ((Math.round(_size * 100) / 100) > 200) {
            $('#file').val('');
            $('#Applicant_photo').val('');
            alert('Please Upload a image less than 200kb');
        }
    });
    $('#file1').change(function(event) {
        var _size = this.files[0].size;
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var ext = this.files[0].name.split('.').pop();
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file1').val('');
                $('#age_proof_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file1').val('');
                $('#age_proof_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file1').val('');
            $('#age_proof_doc').val('');
            alert('Invalid file type !!');
        }

    });
    $('#file2').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file2').val('');
                $('#add_proof_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file2').val('');
                $('#add_proof_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file2').val('');
            $('#add_proof_doc').val('');
            alert('Invalid file type !!');
        }
        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file2').val('');
        //     $('#add_proof_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
    $('#file3').change(function(event) {
        var _size = this.files[0].size;
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if ((Math.round(_size * 100) / 100) > 200) {
            $('#file3').val('');
            $('#fam_proof_doc').val('');
            alert('Please Upload a image less than 200kb');
        }
    });
    $('#file4').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file4').val('');
                $('#in_proof_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file4').val('');
                $('#in_proof_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file4').val('');
            $('#in_proof_doc').val('');
            alert('Invalid file type !!');
        }
        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file4').val('');
        //     $('#in_proof_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
    $('#file5').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file5').val('');
                $('#mark_sheet_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file5').val('');
                $('#mark_sheet_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file5').val('');
            $('#mark_sheet_doc').val('');
            alert('Invalid file type !!');
        }
        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file5').val('');
        //     $('#mark_sheet_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
    $('#file6').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file6').val('');
                $('#rental_letter_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file6').val('');
                $('#rental_letter_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file6').val('');
            $('#rental_letter_doc').val('');
            alert('Invalid file type !!');
        }
        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file6').val('');
        //     $('#rental_letter_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
    $('#file7').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file7').val('');
                $('#medical_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file7').val('');
                $('#medical_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file7').val('');
            $('#medical_doc').val('');
            alert('Invalid file type !!');
        }

        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file7').val('');
        //     $('#medical_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
    $('#file8').change(function(event) {
        var _size = this.files[0].size;
        var ext = this.files[0].name.split('.').pop();
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i = 0;
        while (_size > 900) {
            _size /= 1024;
            i++;
        }
        var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
        if (ext == 'pdf' || ext == 'docx' || ext == 'doc') {
            if ((Math.round(_size * 100) / 100) > 1200) {
                $('#file8').val('');
                $('#other_doc').val('');
                alert('Please Upload a file less than 1.2MB');
            }
        } else if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
            if ((Math.round(_size * 100) / 100) > 200) {
                $('#file8').val('');
                $('#other_doc').val('');
                alert('Please Upload a image less than 200kb');
            }
        } else {
            $('#file8').val('');
            $('#other_doc').val('');
            alert('Invalid file type !!');
        }
        // if((Math.round(_size*100)/100) > 1200){
        //     $('#file8').val('');
        //     $('#other_doc').val('');
        //     alert('Please Upload a image less than 200kb');
        // }
    });
</script>