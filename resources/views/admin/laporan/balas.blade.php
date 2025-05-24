@extends('admin.dashboard-admin')

@section('title', 'Konsultasi')

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Konsultasi Pelanggan</h1>

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
                            <!-- Messages will be loaded here -->
                            <div id="chat-messages"></div>
                        </div>
                        
                        <!-- Reply Form -->
                        <form id="reply-form">
                            <div class="form-group">
                                <textarea class="form-control" id="message-input" rows="3" placeholder="Ketik balasan Anda..." required></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Balas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection