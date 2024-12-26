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
                    <a href="./courses.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'courses.php' || basename($_SERVER['PHP_SELF']) ==  'add_course.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Courses</a>
                    <a href="./attendence.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'attendence.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Attendence</a>
                    <a href="./assignments.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'assignments.php' || basename($_SERVER['PHP_SELF']) ==  'add_assignment.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Assignments</a>
                    <a href="./assignment_solutions.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'assignment_solutions.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Assign. Solutions</a>
                    <a href="./quizes.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'quizes.php' || basename($_SERVER['PHP_SELF']) ==  'add_quiz.php'? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Quizes</a>
                    <a href="./quiz_solutions.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'quiz_solutions.php' ? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Quiz Solutions</a>
                    <a href="./messages.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Messages</a>
                    <a href="./live_chat.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'live_chat.php' ? 'active' : ''; ?>"><i class="fa fa-th me-2"></i>Live Chat</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
