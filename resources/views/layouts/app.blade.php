<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 220px;
            /* Fixed width */
            min-width: 220px;
            /* Prevents shrinking */
            max-width: 220px;
            /* Prevents expanding */
            background: #f8f9fa;
            padding: 20px;
            height: 100vh;
            border-right: 1px solid #ddd;
            flex-shrink: 0;
            /* Prevents sidebar from shrinking on flex containers */
        }

        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #343a40;
            color: white;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
        }

        .main-content {
            padding: 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h5>Invoice Management</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="/dashboard" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            @auth
            @if(auth()->user()->role == 1)
            <li class="nav-item mb-2">
                <a href="{{ route('products.import') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-upload me-2"></i> Import Products
                </a>
            </li>
            @endif

            <li class="nav-item mb-2">
                <a href="{{ route('invoices.index') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-file-earmark-text me-2"></i> Manage Invoices
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('products.index') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-box-seam me-2"></i> View Products
                </a>
            </li>
            @endauth
        </ul>

    </div>

    <!-- Main Content Area -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar d-flex justify-content-between align-items-center">
            <div><strong>Invoice System</strong></div>
            <div>
                @auth
                @php
                $user = auth()->user();
                $firstName = explode(' ', $user->name)[0];
                $initial = strtoupper(substr($firstName, 0, 1));
                $profileImage = $user->profile_image ?? null; // Assuming optional
                @endphp

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($profileImage)
                        <img src="{{ asset('storage/' . $profileImage) }}" alt="Profile" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                        @else
                        <div class="rounded-circle bg-secondary text-white text-center me-2" style="width: 35px; height: 35px; line-height: 35px;">
                            {{ $initial }}
                        </div>
                        @endif
                        <!-- <span>{{ $firstName }}</span> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>

                </div>
                @endauth

            </div>
        </div>

        <!-- Page Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('scripts')

    <script>
        toastr.options = {
            "positionClass": "toast-bottom-right", // 👈 This line moves it to bottom-right
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000",
        };

        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
        @endif

        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif
    </script>

</body>

</html>