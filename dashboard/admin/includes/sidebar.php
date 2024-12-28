<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"></i>Dashboard</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?php echo "../../{$user['profile']}" ?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $user['name']; ?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php'? 'active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Users</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="./user_student.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_student.php'? 'active' : ''; ?>">Students</a>
                            <a href="./user_teacher.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_teacher.php'? 'active' : ''; ?>">Teachers</a>
                            <a href="./user_management.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_management.php'? 'active' : ''; ?>">Management</a>
                            <a href="./add_user.php" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'add_user.php'? 'active' : ''; ?>">Add User</a>
                        </div>
                    </div>
                    <a href="./courses.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'courses.php' || basename($_SERVER['PHP_SELF']) ==  'add_course.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Courses</a>
                    <a href="./finanace.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'finanace.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Finance</a>
                    <a href="./semesters.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'semesters.php' || basename($_SERVER['PHP_SELF']) ==  'add_semester.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Semesters</a>
                    <a href="./announcements.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'announcements.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Announcements</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Send Message</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="./warning.php?user=student" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_student.php'? 'active' : ''; ?>">Students</a>
                            <a href="./warning.php?user=teacher" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_teacher.php'? 'active' : ''; ?>">Teachers</a>
                            <a href="./warning.php?user=management" class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_teacher.php'? 'active' : ''; ?>">Management</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
