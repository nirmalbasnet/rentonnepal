<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard")}}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/agents")}}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Agents</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/agent-rating")}}">
                <i class="mdi mdi-star menu-icon"></i>
                <span class="menu-title">Agent Rating</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/users")}}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        @endhasanyrole

        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/posts")}}">
                <i class="mdi mdi-buffer menu-icon"></i>
                <span class="menu-title">Posts</span>
            </a>
        </li>

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/contacts")}}">
                <i class="mdi mdi-contact-mail menu-icon"></i>
                <span class="menu-title">Contact Details</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/newsletter-subscribers")}}">
                <i class="mdi mdi-at menu-icon"></i>
                <span class="menu-title">Newsletter Subscribers</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{url("dashboard/messages")}}">
                <i class="mdi mdi-message menu-icon"></i>
                <span class="menu-title">Messages</span>
            </a>
        </li>
        @endhasanyrole
    </ul>
</nav>
<!-- partial -->