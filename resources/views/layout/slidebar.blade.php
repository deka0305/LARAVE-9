<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
 <nav id="sidebar" class="sidebar d-flex flex-column align-items-start p-4">
            <h3 class="mb-4 fw-bold text-primary"><i class="bi bi-stack me-2"></i>OrderApp</h3>
            <ul class="nav flex-column w-100">
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center sidebar-link" href="/dashboard">
                        <i class="bi bi-house-door me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center sidebar-link" href="{{ route('orders.create') }}">
                        <i class="bi bi-plus-circle me-2"></i> <span>Input Order</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center sidebar-link" href="/orders">
                        <i class="bi bi-table me-2"></i> <span>Data Orders</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center sidebar-link" href="/tiket">
                        <i class="bi bi-ticket me-2"></i> <span>Tiket</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center sidebar-link" href="/newpage">
                        <i class="bi bi-file-earmark me-2"></i> <span>New Page</span>
                    </a>
                </li>
            </ul>
        </nav>
        <style>
.sidebar {
    min-width: 220px;
    min-height: 100vh;
    background: linear-gradient(135deg, #1e293b 60%, #3b82f6 100%);
    color: #fff;
    box-shadow: 2px 0 16px rgba(30,41,59,0.10);
    border-top-right-radius: 24px;
    border-bottom-right-radius: 24px;
}
.sidebar h3 {
    letter-spacing: 1px;
    font-size: 1.6rem;
    color: #fff;
    text-shadow: 0 2px 8px rgba(59,130,246,0.10);
}
.sidebar-link {
    color: #fff;
    font-weight: 500;
    font-size: 1.08rem;
    border-radius: 10px;
    padding: 10px 18px;
    margin-bottom: 4px;
    transition: background 0.2s, color 0.2s;
}
.sidebar-link.active, .sidebar-link:hover {
    background: #fff;
    color: #3b82f6 !important;
    box-shadow: 0 2px 8px rgba(59,130,246,0.10);
}
.sidebar-link i {
    font-size: 1.2em;
}
@media (max-width: 900px) {
    .sidebar { min-width: 60px; padding: 12px 4px; }
    .sidebar h3, .sidebar-link span { display: none; }
    .sidebar-link { justify-content: center; padding: 10px 0; }
}
</style>