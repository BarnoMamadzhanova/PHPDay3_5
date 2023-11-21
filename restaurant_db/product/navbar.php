

<?php

    $navbar = " 
    <nav class='navbar navbar-expand-lg fixed-top bg-dark opacity-75 border-bottom border-body' data-bs-theme='dark'>
        <div class='container-fluid'>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarTogglerDemo01'
                aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarTogglerDemo01'>
                <a class='navbar-brand' href='index.php'><img src='../assets/logo.png' class='logoImg' alt='logo'></a>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='../index.php'>
                            <h4 class='link'>Home</h4>
                        </a>
                    </li>";

                    if(isset($_SESSION["adm"])){
                        $navbar .= "
                        <li class='nav-item'>
                            <a class='nav-link' aria-current='page' href='../users/dashboard.php'>
                                <h4 class='link'>User Dashboard</h4>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' aria-current='page' href='product_dashboard.php'>
                                <h4 class='link'>Product Dashboard</h4>
                            </a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' aria-current='page' href='create.php'>
                            <h4 class='link'>Create</h4>
                        </a>
                    </li>";
                    }


                    $navbar .= (isset($_SESSION["user"]) || isset($_SESSION["adm"])) ?
                    "<li class='nav-item'>
                        <a class='nav-link' aria-current='page' href='../users/update.php'>
                            <h4 class='link'>Update</h4>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' aria-current='page' href='../users/logout.php'>
                            <h4 class='link'>Log out</h4>
                        </a>
                    </li>":
                    "<li class='nav-item'>
                        <a class='nav-link' aria-current='page' href='../users/register.php'>
                            <h4 class='link'>Register</h4>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' aria-current='page' href='../users/login.php'>
                            <h4 class='link'>Log in</h4>
                        </a>
                    </li>";

                    $navbar .= " 
                </ul>
            </div>
        </div>
</nav>
";