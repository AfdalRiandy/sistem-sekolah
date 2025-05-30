<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAMAS - Sistem Informasi Kegiatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        .hero-section {
            background: linear-gradient(rgba(85, 223, 78, 0.9), rgba(21, 136, 46, 0.8)), center/cover no-repeat;
            color: white;
            padding: 120px 0;
            margin-bottom: 60px;
        }
        .event-card {
            transition: transform 0.3s ease;
            margin-bottom: 25px;
            height: 100%;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .btn-register {
            background-color: #52b788;
            border-color: #52b788;
        }
        .btn-register:hover {
            background-color: #28b774;
            border-color: #28b774;
        }
        /* Override Bootstrap's primary button with green */
        .btn-primary {
            background-color: #52b788 !important;
            border-color: #52b788 !important;
        }
        .btn-primary:hover {
            background-color: #28b774 !important;
            border-color: #28b774 !important;
        }
        .btn-outline-primary {
            color: #52b788 !important;
            border-color: #52b788 !important;
        }
        .btn-outline-primary:hover {
            background-color: #52b788 !important;
            color: white !important;
        }
        .text-primary {
            color: #52b788 !important;
        }
        .feature-box {
            padding: 30px 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #52b788;
        }
        .section-title {
            position: relative;
            margin-bottom: 40px;
            padding-bottom: 15px;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #52b788;
        }
        .footer {
            background-color: #1a202c;
            color: white;
            padding: 40px 0;
        }
        .event-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .bg-primary {
            background-color: #52b788 !important;
        }
        .border-left-primary {
            border-left-color: #52b788 !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-sm navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-primary" href="{{ url('/') }}">
                <i class="mr-2 fas fa-calendar-alt"></i>SIKAMAS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="ml-auto navbar-nav">
                    @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->role == 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                                </li>
                            @elseif(auth()->user()->role == 'panitia')
                                <li class="nav-item">
                                    <a href="{{ route('panitia.dashboard') }}" class="nav-link">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('peserta.dashboard') }}" class="nav-link">Dashboard</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="px-4 text-white nav-link btn btn-primary">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="text-center hero-section">
        <div class="container">
            <h1 class="mb-4 display-4 font-weight-bold">Find and Join Community Events</h1>
            <p class="mb-5 lead">Discover events, register online, and participate in community activities.</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'panitia' ? route('panitia.dashboard') : route('peserta.dashboard')) }}" class="px-5 btn btn-light btn-lg">
                        Go to Dashboard
                    </a>
                @else
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('login') }}" class="px-4 mr-3 btn btn-outline-light btn-lg">
                            <i class="mr-2 fas fa-sign-in-alt"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 btn btn-light btn-lg">
                            <i class="mr-2 fas fa-user-plus"></i>Register
                        </a>
                    </div>
                @endauth
            @endif
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="container mb-5">
        <h2 class="text-center section-title">Upcoming Events</h2>
        
        <div class="row">
            @php
                $upcomingEvents = App\Models\Acara::where('tanggal_acara', '>', now())
                    ->where('batas_pendaftaran', '>', now())
                    ->latest('tanggal_acara')
                    ->take(6)
                    ->get();
            @endphp
            
            @forelse($upcomingEvents as $event)
                <div class="col-md-4">
                    <div class="shadow card event-card h-100">
                        @if(\Carbon\Carbon::parse($event->tanggal_acara)->diffInDays(now()) < 7)
                            <div class="badge badge-danger event-badge">New!</div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $event->nama_acara }}</h5>
                            <p class="card-text text-muted">
                                <i class="mr-2 fas fa-calendar-day"></i>{{ \Carbon\Carbon::parse($event->tanggal_acara)->format('d M Y') }}
                            </p>
                            <p class="card-text">{{ Str::limit($event->deskripsi_acara, 100) }}</p>
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="mr-1 fas fa-users"></i> 
                                    {{ $event->pendaftaran->count() }}/{{ $event->maksimal_peserta }} registered
                                </small>
                                
                                @if(auth()->check())
                                    <a href="{{ route('peserta.acara.show', $event->id) }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                                        Login to Join
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="bg-transparent card-footer">
                            <small class="text-muted">
                                Registration closes: {{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <div class="alert alert-info">
                        <i class="mr-2 fas fa-info-circle"></i>No upcoming events at the moment. Please check back later.
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($upcomingEvents->count() > 0)
            <div class="mt-4 text-center">
                @auth
                    <a href="{{ route('peserta.acara.index') }}" class="btn btn-primary">
                        View All Events
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login to View All Events
                    </a>
                @endauth
            </div>
        @endif
    </section>

    <!-- Features Section -->
    <section class="py-5 mb-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">Why Join Us?</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Easy Registration</h4>
                        <p>Register for events with just a few clicks. No paperwork, no hassle.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h4>Track Your Performance</h4>
                        <p>View your event results and achievements all in one place.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Stay Updated</h4>
                        <p>Get the latest information about upcoming community events.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4>SIKAMAS</h4>
                    <p>Sistem Informasi Kegiatan</p>
                </div>
                <div class="col-lg-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        @guest
                            <li><a href="{{ route('login') }}" class="text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-white">Register</a></li>
                        @else
                            <li><a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'panitia' ? route('panitia.dashboard') : route('peserta.dashboard')) }}" class="text-white">Dashboard</a></li>
                        @endguest
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="mr-2 fas fa-envelope"></i> info@sikamas.com</li>
                        <li><i class="mr-2 fas fa-phone"></i> (123) 456-7890</li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} SIKAMAS. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>