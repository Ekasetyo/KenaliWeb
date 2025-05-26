@extends('admin.dashboard-admin')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Konsultasi Pelanggan</h1>

            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status-filter">Filter Status</label>
                        <select class="form-control" id="status-filter">
                            <option value="all">Semua</option>
                            <option value="active">Aktif</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date-filter">Filter Tanggal</label>
                        <input type="date" class="form-control" id="date-filter">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search">Cari Konsultasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" placeholder="Cari...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Konsultasi</h6>
                    <button class="btn btn-primary btn-sm" id="refresh-btn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="consultationTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Data -->
                                <tr>
                                    <td>1</td>
                                    <td>Budi Santoso</td>
                                    <td>budi@example.com</td>
                                    <td>Pertanyaan Produk</td>
                                    <td><span class="badge badge-primary">Aktif</span></td>
                                    <td>15 Jun 2023 10:30</td>
                                    <td>
                                        <button class="btn btn-info btn-sm view-chat" data-id="1">
                                            <i class="fas fa-comments"></i> Buka Chat
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Ani Wijaya</td>
                                    <td>ani@example.com</td>
                                    <td>Keluhan Layanan</td>
                                    <td><span class="badge badge-secondary">Selesai</span></td>
                                    <td>14 Jun 2023 09:15</td>
                                    <td>
                                        <button class="btn btn-info btn-sm view-chat" data-id="2">
                                            <i class="fas fa-comments"></i> Buka Chat
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Citra Dewi</td>
                                    <td>citra@example.com</td>
                                    <td>Keluhan</td>
                                    <td><span class="badge badge-primary">Aktif</span></td>
                                    <td>13 Jun 2023 13:45</td>
                                    <td>
                                        <button class="btn btn-info btn-sm view-chat" data-id="3">
                                            <i class="fas fa-comments"></i> Buka Chat
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chat Konsultasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="chat-header mb-3">
                            <h6>Pelanggan: <span id="customer-name">Budi Santoso</span></h6>
                            <p>Email: <span id="customer-email">budi@example.com</span> | Topik: <span id="consultation-topic">Pertanyaan Produk</span></p>
                        </div>
                        
                        <!-- Chat Messages Container -->
                        <div id="chat-container" style="height: 300px; overflow-y: auto; margin-bottom: 20px; padding: 15px; border: 1px solid #e3e6f0; border-radius: 5px; background-color: #fafafa;">
                            <!-- Sample Chat Messages -->
                            <div class="message user-message mb-3">
                                <div class="message-header">
                                    <strong>Budi Santoso</strong>
                                    <small class="text-muted">15 Jun 2023 10:30</small>
                                </div>
                                <div class="message-body">
                                    Selamat pagi, saya ingin bertanya tentang produk X yang baru diluncurkan.
                                </div>
                            </div>
                            
                            <div class="message admin-message mb-3">
                                <div class="message-header">
                                    <strong>Anda</strong>
                                    <small class="text-muted">15 Jun 2023 10:35</small>
                                </div>
                                <div class="message-body">
                                    Selamat pagi Pak Budi, produk X tersedia dalam 3 varian. Apa yang ingin Anda ketahui?
                                </div>
                            </div>

                            <!-- Chat will dynamically appear here -->
                            <div id="chat-messages"></div>
                        </div>
                        
                        <!-- Reply Form -->
                        <form id="reply-form">
                            <div class="form-group">
                                <textarea class="form-control" id="message-input" rows="3" placeholder="Ketik balasan Anda..." required></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                                <button type="button" class="btn btn-success" id="mark-completed">
                                    <i class="fas fa-check"></i> Tandai Selesai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
