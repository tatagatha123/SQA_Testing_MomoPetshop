<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Momo Petshop</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background-color: #ff9ecb;
            min-height: 100vh;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            color: white;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #ff70b5;
        }

        /* CONTENT */
        .content {
            flex: 1;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }

        footer {
            margin-top: 20px;
            text-align: center;
            color: gray;
        }

        .sidebar a.active {
        background-color: #ff70b5;
        border-radius: 5px;
        }      

        .badge {
        background-color: red;
        color: white;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 12px;
        float: right;
        }

        .btn {
        display: inline-block;
        padding: 8px 15px;
        background-color: #ff70b5;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        }

        .btn:hover {
        background-color: #ff4da6;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Momo 🐾</h2>

    <a href="/" class="<?= ($menu == 'dashboard') ? 'active' : '' ?>">
        Dashboard
    </a>

    <a href="/produk" class="<?= ($menu == 'produk') ? 'active' : '' ?>">
        Produk
    </a>

    <a href="/transaksi" class="nav-link <?= (($menu ?? '') == 'transaksi') ? 'active' : ''; ?>">
    <i class="fa fa-shopping-cart"></i>
    <span>Transaksi</span>
    </a>

    <a href="/laporan" class="nav-link <?= (($menu ?? '') == 'laporan') ? 'active' : ''; ?>">
    <i class="fa fa-chart-bar"></i>
    <span>Laporan</span>
    </a>

    <a href="#">Logout</a>
</div>

    <div class="content">
        <?= $this->renderSection('content'); ?>
        <footer>
            © <?= date('Y'); ?> Momo Petshop
        </footer>
    </div>

</body>
</html>