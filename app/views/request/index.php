<?php
global $__page_title;

$__page_title = "Create New";
$__html_title = $__page_title;
$pageActive = "master";

$__navigation = '<li><a href="#">Request for Review</a></li>';
$__navigation .= '<li class="last">'.$__page_title.'</li>';
require_once(BASE_DIR."inc/header.php");


?>

<div class="row">
    <div class="col-md-12">
        <!-- BOX -->
        <div class="box border inverse" id="formWizard">
            <div class="box-title">
                <h4><i class="fa fa-bars"></i>Create New Form <span class="stepHeader"></span></h4>

            </div>

            <div class="box-body form">


                <form id="finput" name="forminput" action="<?= BASE_URL ?>request/submit"role="form" enctype="multipart/form-data" method="post" class="form-horizontal">
                    <div class="wizard-form">
                        <div class="wizard-content" id="tabnya">
                            <ul class="nav nav-pills nav-justified steps">
                                <li id="dailyheader">
                                    <a href="#account" data-toggle="tab" class="wiz-step">
                                        <!--<span class="step-number"></span>-->
                                        <span class="step-name"><i class="fa fa-check"></i> <font color="white">Formulir Request</font></span>




                                    </a>
                                </li>


                            </ul>
                            <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
                                <div class="progress-bar progress-bar-warning"></div>
                            </div>
                            <div class="tab-content">


                         
                                <div class="tab-pane active" id="account">
                                    <input type="hidden" id="kode" name="kode" value="" />


                                    <div class="form-group">
                                        <span class="control-label col-md-3">(*) Is a Mandatory Field</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Type of Document</label>
                                        <div class="col-md-4">
                                            <select name="document_type" id="document_type" class="form-control input-sm">	
                                            <?php foreach($document_types as $doc_type){ ?>
                                                <option value="<?= $doc_type['id'] ?>"><?= $doc_type['name'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Document Name*</label>
                                        <div class="col-md-4">
                                            <input type="text" name="document_name" id="document_name" class="form-control input-sm validate[required]" required="required" />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Dokument Status</label>
                                        <div class="col-md-4">
                                            <select name="document_status" id="document_status" class="form-control input-sm" />
                                            <?php foreach($document_status as $doc_status){ ?>
                                                <option value="<?= $doc_status['id'] ?>"><?= $doc_status['name'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Document Number*</label>
                                        <div class="col-md-4">
                                            <input type="text" name="document_number" id="document_number" class="form-control input-sm validate[required]" required="required" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Document Date*</label>
                                        <div class="col-md-4">
                                            <input type="text" name="document_date" id="document_date" class="form-control input-sm datepicker" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Subject</label>
                                        <div class="col-md-4">
                                            <input type="text" name="subject" id="subject" class="form-control input-sm" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Location </label>
                                        <div class="col-md-4">
                                            <select name="location" id="location" class="form-control input-sm" />
                                            <?php foreach($location as $loc){ ?>
                                                <option value="<?= $loc['idlocation'] ?>"><?= $loc['location'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <form id="uploadImage" action="upload.php" method="post">
                                        <div class="form-group">
                                            <label>File Upload</label>
                                            <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" id="uploadSubmit" value="Upload" class="btn btn-info" />
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div id="targetLayer" style="display:none;"></div>
                                    </form>
                                            -->

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ------------------------------------------------------------------------------------------- -->

                    <div class="wizard-buttons">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-offset-3 col-md-9">
                                    <!--  <a href="javascript:;" class="btn btn-default prevBtn">
														<i class="fa fa-arrow-circle-left"></i> Back </a>
													   <a href="javascript:;" class="btn btn-primary nextBtn">
														Continue <i class="fa fa-arrow-circle-right"></i>
													   </a>
													  -->
                                    <button type="submit" id="submit" class="btn btn-primary">Simpan</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                

            </div>
        </div>
    </div>
</div>
<?php
require_once(BASE_DIR."/inc/footer.php");
?>