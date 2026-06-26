<style>
    .dashboard-box {
        position: relative;
        border-radius: 12px;
        color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    }

    .dashboard-box .inner {
        z-index: 2;
    }

    .dashboard-box .inner h3 {
        font-size: 2.2rem;
        margin: 0;
        font-weight: bold;
    }

    .dashboard-box .inner p {
        font-size: 1.1rem;
        margin-top: 5px;
    }

    .dashboard-box .icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 3rem;
        opacity: 0.2;
    }

    .dashboard-footer {
        display: block;
        padding: 10px 0 5px;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        margin-top: 10px;
    }

    .dashboard-footer i {
        margin-left: 5px;
    }

    .bg-success {
        background: linear-gradient(135deg, #28a745, #218838);
    }

    .bg-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .bg-info {
        background: linear-gradient(135deg, #17a2b8, #117a8b);
    }

    .bg-danger {
        background: linear-gradient(135deg, #dc3545, #a71d2a);
    }

    .bg-dark {
        background: linear-gradient(135deg, #343a40, #1d2124);
    }
</style>

<div class="row dashboard-row">
    @role('admin')
        <div class="col-lg-3 col-6">
            <div class="dashboard-box bg-info">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('admin.user.index') }}" class="dashboard-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-box bg-primary">
                <div class="inner">
                    <h3>{{ $pasientidakbatal }}</h3>
                    <p>Registrasi Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <a href="{{ route('admin.pendaftaran.index') }}" class="dashboard-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-box bg-success">
                <div class="inner">
                    <h3>{{ $dokterCount }}</h3>
                    <p>Jumlah Dokter</p>
                </div>
                <div class="icon"><i class="fas fa-user-md"></i></div>
                <a href="{{ route('admin.dokter.index') }}" class="dashboard-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-box bg-danger">
                <div class="inner">
                    <h3>{{ $pasienbatal }}</h3>
                    <p>Registrasi Batal</p>
                </div>
                <div class="icon"><i class="fas fa-times-circle"></i></div>
                <a href="{{ route('admin.pendaftaran.index') }}" class="dashboard-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="dashboard-box bg-dark">
                <div class="inner">
                    <h3>{{ $collection }}</h3>
                    <p>Total Collections</p>
                </div>
                <div class="icon"><i class="fas fa-file-pdf"></i></div>
                <a href="{{ route('admin.collection.index') }}" class="dashboard-footer">View <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endrole
</div>
