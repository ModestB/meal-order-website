<?php
include "partials/_header.php";
include "functions.php";
session_start();
if(isset($_GET["update"])):
    updateMealPlans();
endif;
if(isset($_GET["delete"])):
    clearTables();
endif;
if(!isset($_SESSION['username'])):
    $_SESSION['message'] = "Please Login!!!";
    header('location: index.php?login=failed');
endif;
$weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
$usersData = getAllUsersData();
$users = getUsers();
$usersWithOrders = [];
$usersWithoutOrders = [];
?>
<body>
    <div class="container-fluid d-flex  flex-column justify-content-center align-items-center">
        <div class="container-big d-flex justify-content-start mb-0 ml-5 heading-text-container">
            <h4 class="heading-text mt-4 mb-0">Employees Orders</h4>
            <h4 class="heading-text heading-text-inactive mt-4 mb-0">Statistics</h4>
        </div>
        <div class="container-big d-flex justify-content-center align-items-center mt-0">
            <div class="admin-page">
                <p class="username mt-3">
                    <i class="icon-user"></i>
                    <?php echo ucfirst($_SESSION['username'])?>
                    <a href="index.php?logout=true">Logout</a>
                </p>
                <?php
                if($_SESSION['message']):
                    ?>
                    <div class='w-100 success-msg' id="msg">
                        <p class="text-center"><?php echo $_SESSION['message'] ?></p>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                foreach($users as $user):
                    array_push($usersWithoutOrders, $user['username']);
                    foreach($usersData as $userData):
                        if($user['username'] == $userData['username']):
                            array_push($usersWithOrders, $user['username']);
                            break;
                        endif;
                    endforeach;  
                endforeach;

                foreach($users as $user):
                    foreach($usersWithOrders as $userWithOrder):
                        if($user['username'] == $userWithOrder):
                            $index = array_search($user['username'], $usersWithoutOrders);
                            unset($usersWithoutOrders[$index]);
                            break;
                        endif;
                    endforeach;  
                endforeach;

                $adminIndex = array_search('admin', $usersWithoutOrders);
                unset($usersWithoutOrders[$adminIndex]);
                ?>
                <div class="table-responsive px-3">
                    <table class="display table table-hover table-bordered" id="tableExample">
                        <thead>
                            <tr>
                                <th class="text-nowrap" scope="col">Employe</th>
                                <th class="text-nowrap" scope="col" style="width: 80px;">Week Day</th>
                                <th class="text-nowrap" scope="col">Soup</th>
                                <th class="text-nowrap" scope="col">Salads</th>
                                <th class="text-nowrap" scope="col">Salads Addon</th>
                                <th class="text-nowrap" scope="col">Main Dish</th>
                                <th class="text-nowrap" scope="col">Side Dish Hot</th>
                                <th class="text-nowrap" scope="col">Side Dish Cold</th>
                                <th class="text-nowrap" scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            foreach($weekDays as $weekDay):
                                foreach($usersWithOrders as $user):
                                ?>
                                <tr>
                                    <th>
                                        <?php echo ucfirst($user);?>
                                    </td>
                                    <td><?php echo $index . ". " . ucfirst($weekDay) ?></td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['soup'] != "NULL"):
                                                echo $userData['soup'] . " " . $userData['soup_price'] . " eur";
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['salads'] != "NULL"):
                                                echo $userData['salads'] . " " . $userData['salads_price'] . " eur";
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?>
                                    </td>
                                    <td>  
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['salads_addons'] != "NULL"):
                                                echo $userData['salads_addons'] . " " . $userData['salads_addons_price'] . " eur";
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['main_dish'] != "NULL"):
                                                echo $userData['main_dish'] . " " . $userData['main_dish_price'] . " eur";
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?>   
                                    </td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['side_dish_hot'] != "NULL"):
                                                echo $userData['side_dish_hot'];
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?>  
                                    </td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            if($userData['side_dish_cold'] != "NULL"):
                                                echo $userData['side_dish_cold'];
                                            else:
                                                echo "-";
                                            endif;
                                        endif;
                                    endforeach;
                                    ?> 
                                    </td>
                                    <td>
                                    <?php
                                    foreach($usersData as $userData):
                                        if($userData['username'] == $user && $userData['week_day'] == $weekDay ):
                                            echo $userData['total_price'] . " eur";
                                        endif;
                                    endforeach;
                                    ?> 
                                    </td>
                                </tr>   
                                <?php
                                endforeach;
                                $index++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <p class="pl-3 text-danger"> Users without order: 
                <?php
                foreach($usersWithoutOrders as $userWithoutOrder):
                    echo ucfirst($userWithoutOrder) . " ";
                endforeach;
                ?>
                </p>
                <a href="admin_page.php?delete=true" class="btn btn-danger mb-3 mt-auto mx-3">Reset Meal Plans</a>          
            </div>
            <div class="statistics-page d-none">
                <p class="username mt-3">
                    <i class="icon-user"></i>
                    <?php echo ucfirst($_SESSION['username'])?>
                    <a href="index.php?logout=true">Logout</a>
                </p>
                <div class="table-responsive px-3">
                    <table class="display table table-hover table-bordered" id="tableExample2">
                        <thead>
                            <tr>
                                <th class="text-nowrap" scope="col">Meal</th>
                                <th class="text-nowrap" scope="col">Number</th>
                                <th class="text-nowrap" scope="col">Total Price</th>
                                <th class="text-nowrap" scope="col">Day</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($weekDays as $day):
                            foreach(getOrderWithStatistics($day, $usersData) as $dishOrder):
                            ?>
                            <tr>
                                <td>
                                    <?php echo $dishOrder['title'];?>
                                </td>
                                <td>
                                    <?php echo $dishOrder['count'];?>
                                </td>
                                <td>
                                    <?php
                                    if($dishOrder['price'] > 0):
                                        echo $dishOrder['price'];
                                    else:
                                        echo " - ";
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?php echo ucfirst($day);?>
                                </td>
                            </tr> 
                            <?php
                            endforeach;
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>           
        </div>
    </div>
<?php
include "partials/_footer.php";
?>