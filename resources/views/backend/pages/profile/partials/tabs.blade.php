<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
            <i class="bx bx-user me-1"></i>Profile
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'profile.change-password' ? 'active' : '' }}" href="{{ route('profile.change-password') }}">
            <i class="bx bx-lock me-1"></i>Password
        </a>
    </li>
</ul>