<?php $this->extend('inc/main');?>
<?php $this->section('css');?>
<?php $this->endSection();?>
<?php $this->section('body');?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="container mt-5">
        <h3 class="mt-5">Selamat datang di dashboard, <?= $dataUsers->namaKaryawan ?>!</h3>
        <div class="card mt-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Data Diri</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nama: <?= $dataUsers->namaKaryawan ?></li>
                    <li class="list-group-item">NIP: <?= $dataUsers->NIP ?></li>
                    <li class="list-group-item">Email: <?= $dataUsers->email ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<?php $this->endSection();?>