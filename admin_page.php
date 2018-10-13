<?php
include "partials/_header.php";
include "inclusions/_inc_functions.php";
include "functions.php";
session_start();
if(isset($_GET["update"])):
    updateMealPlans();
endif;
?>
 <?php
if(isset($_GET["delete"])):
    clearTables();
endif;
?>

<body>
    
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="container-big d-flex justify-content-center align-items-center">
            <div class="admin-page d-flex flex-column">
                <p class="username">
                    <i class="icon-user"></i>
                    <?php echo $_SESSION['username']?>
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
            $weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
            $usersData = getAllUsersData();
            $users = gerUsers();
            //print_r($usersData);
            foreach($weekDays as $weekDay):
            ?>
            <h2 class="pl-2"><?php echo ucfirst($weekDay) ?></h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-nowrap" scope="col">Employe</th>
                            <th class="text-nowrap" scope="col">Soup</th>
                            <th class="text-nowrap" scope="col">Salads</th>
                            <th class="text-nowrap" scope="col">Salads Addon</th>
                            <th class="text-nowrap" scope="col">Main Dish</th>
                            <th class="text-nowrap" scope="col">Side Dish Hot</th>
                            <th class="text-nowrap" scope="col">Side Dish Cold</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        foreach($users as $user):
                        ?>
                        <tr>
                            <th><?php echo $user['username'] ?></td>
                            <td>
                            <?php
                            foreach($usersData as $userData):
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
                                    if($userData['soup'] != "NULL"):
                                        echo $userData['soup'];
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
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
                                    if($userData['salads'] != "NULL"):
                                        echo $userData['salads'];
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
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
                                    if($userData['salads_addons'] != "NULL"):
                                        echo $userData['salads_addons'];
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
                                //print_r($userData);
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
                                    if($userData['main_dish'] != "NULL"):
                                        echo $userData['main_dish'];
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
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
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
                                if($userData['username'] == $user['username'] && $userData['week_day'] == $weekDay ):
                                    if($userData['side_dish_cold'] != "NULL"):
                                        echo $userData['side_dish_cold'];
                                    else:
                                        echo "-";
                                    endif;
                                endif;
                            endforeach;
                            ?> 
                            </td>
                        </tr>   
                        <?php
                        endforeach;
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <?php
            endforeach;
            ?>

            <!-- <a href="personal_page.php?delete=true" class="btn btn-danger">Delete Plans</a> -->
            <a href="personal_page.php?delete=true" class="btn btn-success">Update Plans</a>
            
            </div>           
        </div>
    </div>

<?php
include "partials/_footer.php";
?>