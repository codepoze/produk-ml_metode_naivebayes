 <div class="breadcrumbs">
     <div class="col-sm-4">
         <div class="page-header float-left">
             <div class="page-title">
                 <h1>Evaluasi</h1>
             </div>
         </div>
     </div>
     <div class="col-sm-8">
         <div class="page-header float-right">
             <div class="page-title">
                 <ol class="breadcrumb text-right">
                     <li><a href="dashboard">Dashboard</a></li>
                     <li class="active">Evaluasi</li>
                 </ol>
             </div>
         </div>
     </div>
 </div>

 <div class="content mt-3">
     <div class="animated fadeIn">
         <div class="row">
             <div class="col-lg-12">
                 <!-- begin:: form -->
                 <div class="card">
                     <div class="card-header">
                         <strong>Form</strong>
                     </div>
                     <form class="form-horizontal" action="konsultasi_hasil" method="post">
                         <!-- begin:: id user -->
                         <input type="hidden" name="id_users" id="id_users" value="<?= $rowLog->id_users ?>" />
                         <!-- end:: id user -->

                         <div class="card-body card-block">
                             <?php
                                $query1 = $pdo->GetAll('tb_kriteria', 'id_kriteria');
                                $row = 0;
                                while ($row_k = $query1->fetch(PDO::FETCH_OBJ)) { ?>
                                 <div class="row form-group">
                                     <div class="col col-md-3">
                                         <label for="bobot" class=" form-control-label"><?= $row_k->nama ?>&nbsp;*</label>
                                     </div>
                                     <div class="col-12 col-md-9">
                                         <input type="hidden" name="id_kriteria[]" value="<?= $row_k->id_kriteria ?>" />
                                         <select name="nilai[]" id="nilai_<?= $row++ ?>" class="form-control form-control-sm">
                                             <option value="">- Pilih -</option>
                                             <?php
                                                $query2 = $pdo->GetWhere('tb_kriteria_sub', 'id_kriteria', $row_k->id_kriteria);
                                                while ($row_s = $query2->fetch(PDO::FETCH_OBJ)) { ?>
                                                 <option value="<?= $row_s->nilai ?>"><?= $row_s->nama ?></option>
                                             <?php } ?>
                                         </select>
                                         <small class="help-block form-text error"></small>
                                     </div>
                                 </div>
                             <?php } ?>
                         </div>
                         <div class="card-footer">
                             <button type="reset" class="btn btn-primary btn-sm">
                                 <i class="fa fa-refresh"></i>&nbsp;Reset
                             </button>&nbsp;
                             <button type="submit" name="add" id="add" class="btn btn-success btn-sm">
                                 <i class="fa fa-gear"></i>&nbsp;Proses
                             </button>
                         </div>
                     </form>
                 </div>
                 <!-- end:: form -->
             </div>
         </div>
     </div>
 </div>
 </div>