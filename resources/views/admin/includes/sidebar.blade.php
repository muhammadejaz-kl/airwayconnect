<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ request()->segment(2) === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="feather-grid"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->segment(2) === 'transactions' ? 'active' : '' }}">
                    <a href="{{ route('admin.transactions.index') }}">
                        <i data-feather="dollar-sign"></i> <span>Transactions</span>
                    </a>
                </li>

                <li class="{{ request()->segment(2) === 'users' ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-user-circle"></i> <span>Users</span>
                    </a>
                </li>

                <li class="{{ request()->segment(2) === 'airlines-directory' ? 'active' : '' }}">
                    <a href="{{ route('admin.airlinesDirectory.index') }}">
                        <i class="fas fa-plane"></i> <span>Airlines-Directory</span>
                    </a>
                </li>

                <li class="{{ request()->segment(2) === 'jobs' ? 'active' : '' }}">
                    <a href="{{ route('admin.jobs.index') }}">
                        <i class="fas fa-briefcase"></i> <span>Jobs</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#"
                        class="{{ request()->is('admin/resources*') || request()->is('admin/events*') || request()->is('admin/organizations*') ? 'subdrop' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <span> Resources & More</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul
                        style="{{ request()->is('admin/resources*') || request()->is('admin/events*') || request()->is('admin/organizations*') ? 'display:block;' : '' }}">

                        {{--

                        <li class="{{ request()->segment(2) === 'resources' ? 'active' : '' }}">
                            <a href="{{ route('admin.resources.resourceIndex') }}">Resources</a>
                        </li>

                        --}}

                        <li class="{{ request()->segment(2) === 'events' ? 'active' : '' }}">
                            <a href="{{ route('admin.events.index') }}">Events</a>
                        </li>

                        <li class="{{ request()->segment(2) === 'organizations' ? 'active' : '' }}">
                            <a href="{{ route('admin.organizations.index') }}">Organizations</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#" class="{{ request()->is('admin/forum*') ? 'subdrop' : '' }}">
                        <i class="fas fa-comments"></i> <span> Forum</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('admin/forum*') ? 'display:block;' : '' }}">
                        <li class="{{ request()->segment(3) === 'topic' ? 'active' : '' }}">
                            <a href="{{ route('admin.forum.index') }}">Topics</a>
                        </li>
                        <li
                            class="{{ request()->routeIs('admin.forum.forumIndex') || request()->routeIs('admin.forum.show') ? 'active' : '' }}">
                            <a href="{{ route('admin.forum.forumIndex') }}">Forums</a>
                        </li>
                    </ul>
                </li>
                <!-- 
                <li class="submenu">
                    <a href="#" class="{{ request()->is('admin/interview*') ? 'subdrop' : '' }}">
                        <i class="fas fa-clipboard-list"></i> <span> Classroom</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('admin/interview*') ? 'display:block;' : '' }}">
                        <li class="{{ request()->segment(2) === 'interview' ? 'active' : '' }}">
                            <a href="{{ route('admin.interview.index') }}">Topics</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.interview.interviewIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.interview.interviewIndex') }}">Q&A's</a>
                        </li>
                    </ul>
                </li> -->

                <li class="{{ request()->is('admin/interview*') ? 'active' : '' }}">
                    <a href="{{ route('admin.interview.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Classroom</span>
                    </a>
                </li>


                <li class="{{ request()->segment(2) === 'resume-skills' ? 'active' : '' }}">
                    <a href="{{ route('admin.resumeSkill.index') }}">
                        <i class="fas fa-cogs"></i> <span>Resume Skills</span>
                    </a>
                </li>

                <li class="{{ request()->segment(2) === 'faqs' ? 'active' : '' }}">
                    <a href="{{ route('admin.faqs.index') }}">
                        <i data-feather="help-circle"></i> <span>FAQ's</span>
                    </a>
                </li>

                <!-- <li class="{{ request()->segment(2) === 'testimony' ? 'active' : '' }}">
                    <a href="{{ route('admin.testimony.index') }}">
                        <i data-feather="award"></i> <span>Testimonies</span>
                    </a>
                </li> -->

                <li class="submenu">
                    <a href="#"
                        class="{{ request()->is('admin/subscriptions*') || request()->is('admin/coupons*') ? 'subdrop' : '' }}">
                        <i data-feather="bookmark"></i> <span>Plans & Coupons</span> <span class="menu-arrow"></span>
                    </a>
                    <ul
                        style="{{ request()->is('admin/subscriptions*') || request()->is('admin/coupons*') ? 'display:block;' : '' }}">
                        <li class="{{ request()->segment(2) === 'subscriptions' ? 'active' : '' }}">
                            <a href="{{ route('admin.subscriptions.index') }}">Subscriptions</a>
                        </li>
                        <li class="{{ request()->segment(2) === 'coupons' ? 'active' : '' }}">
                            <a href="{{ route('admin.coupons.index') }}">Coupons</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->segment(2) === 'legals' ? 'active' : '' }}">
                    <a href="{{ route('admin.legals.index') }}">
                        <i data-feather="alert-triangle"></i> <span>Legals</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>