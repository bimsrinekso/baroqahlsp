<?php $this->extend('inc/main');?>
<?php $this->section('css');?>
<?php $this->endSection();?>
<?php $this->section('body');?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-header bg-primary text-white">
                        Total Karyawan
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?=$totalKaryawan[0]->totalKaryawan?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<?php $this->endSection();?>