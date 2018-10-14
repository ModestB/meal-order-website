<?php
include "partials/_header.php";
include "inclusions/_inc_functions.php";
include "functions.php";
session_start();
// if(isset($_GET["update"])):
//     updateMealPlans();
// endif;
// ?>
<?php
// if(isset($_GET["delete"])):
//     clearTables();
// endif;

if(isset($_POST["submit"])):
    //print_r($_POST);
    updateUserOrder();
endif;
$weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
?>

<body> 
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
        <div class="container-big d-flex justify-content-start mb-0">
            <h4 class="heading-text mt-4 mb-0">Choose Meals For Each Day Of The Upcoming Week</h4>
        </div>
        <div class="container-big d-flex justify-content-center align-items-center mt-0">
            <div class="personal-page d-flex flex-column">
                <p class="username mt-3">
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
            if($userData = getUserData()):
            ?>
            <div class="table-responsive px-3">
                <table class="display table table-hover table-bordered" id="tableExample">
                    <thead>
                        <tr>
                            <th class="text-nowrap" scope="col" style="width: 80px;">Week Day</th>
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
                        $currentWeekData;
                        foreach($weekDays as $weekDay):
                            foreach($userData as $data):
                                if($data['week_day'] == $weekDay):
                                    $currentWeekData = $data;
                                endif;  
                            endforeach;
                            ?>
                            <tr>
                                <td><?php echo ucfirst($weekDay) ?></td>
                                <td>
                                <?php
                                if($currentWeekData['soup'] != "NULL"):
                                    echo $currentWeekData['soup'];
                                else:
                                    echo "-";
                                endif;
                                ?>
                                </td>
                                <td>
                                <?php
                                if($currentWeekData['salads'] != "NULL"):
                                    echo $currentWeekData['salads'];
                                else:
                                    echo "-";
                                endif;
                                ?>
                                </td>
                                <td>  
                                <?php
                                if($currentWeekData['salads_addons'] != "NULL"):
                                    echo $currentWeekData['salads_addons'];
                                else:
                                    echo "-";
                                endif;
                                ?>
                                </td>
                                <td>
                                <?php
                                if($currentWeekData['main_dish'] != "NULL"):
                                    echo $currentWeekData['main_dish'];
                                else:
                                    echo "-";
                                endif;
                                ?>   
                                </td>
                                <td>
                                <?php
                                if($currentWeekData['side_dish_hot'] != "NULL"):
                                    echo $currentWeekData['side_dish_hot'];
                                else:
                                    echo "-";
                                endif;
                                ?>  
                                </td>
                                <td>
                                <?php
                                if($currentWeekData['side_dish_cold'] != "NULL"):
                                    echo $currentWeekData['side_dish_cold'];
                                else:
                                    echo "-";
                                endif;
                                ?> 
                                </td>
                            </tr>   
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            <?php
            else:
                ?>
                <form class="p-0 mx-3"  action="personal_page.php" method="post">
                <ul class="list-group">
                    <?php 
                    $index = 0;
                    $userOrderOld = getUserData();
                    $currentWeek = [];
                    $alreadyHavePlan = false;
                    if($userOrderOld){
                        $alreadyHavePlan = true;
                    }
                    $soups = getSoups();
                    $salads = getSalads();
                    $saladsAddons = getSaladsAddons();
                    $mainDishes = getMainDishes();
                    $sideDishes = getSideDishes();

                    foreach($weekDays as $weekday):
                        
                        $currentWeekSoups = [];
                        foreach($soups as $soup):
                            if($soup['week_day'] == $weekday):
                                array_push($currentWeekSoups, $soup);
                            endif;
                        endforeach;

                        
                        $currentWeekSalads = [];
                        foreach($salads as $salad):
                            if($salad['week_day'] == $weekday):
                                array_push($currentWeekSalads, $salad);
                            endif;
                        endforeach;

                        $currentWeekSaladsAddons = [];
                        foreach($saladsAddons as $saladAddon):
                            if($saladAddon['week_day'] == $weekday):
                                array_push($currentWeekSaladsAddons, $saladAddon);
                            endif;
                        endforeach;

                        $currentWeekMainDishes = [];
                        foreach($mainDishes as $mainDish):
                            if($mainDish['week_day'] == $weekday):
                                array_push($currentWeekMainDishes, $mainDish);
                            endif;
                        endforeach;

                        $currentWeekSideDishes = [];
                        foreach($sideDishes as $sideDish):
                            if($sideDish['week_day'] == $weekday):
                                array_push($currentWeekSideDishes, $sideDish);
                            endif;
                        endforeach;

                        foreach($userOrderOld as $userOrder):
                            if($userOrder['week_day'] == $weekday):
                                $currentWeek = $userOrder;
                            endif;
                        endforeach;
                    ?>
                    <li class="list-group-item" id="<?php echo $weekday ?>">
                            <h2><?php echo ucfirst($weekday) ?></h2>
                        <div class="form-group">
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="d-flex  align-items-center">
                                        <p class="m-0 pr-2">Soup</p>
                                        <label class="switch m-0" id="<?php echo $weekday ?>Switch">
                                            <?php 
                                            $checked = "";
                                            if($alreadyHavePlan):
                                                if($userOrderOld[$index]['salads'] != "NULL"):
                                                    $checked = "checked";
                                                endif;
                                            endif;
                                            ?>
                                            <input <?php echo $checked?> type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="m-0 pl-2">Salads</p>
                                    </div>
                                </div>
                            </div>
                            <div class="soup mt-4">
                                <div class="row">
                                    <div class="col">
                                        <label for="<?php echo $weekday ?>Soups">Soups</label>
                                        <select class="form-control" name="<?php echo $weekday ?>Soups" id="<?php echo $weekday ?>Soups">
                                            <option disabled selected value> -- select the soup-- </option>
                                            <?php 
                                            foreach( $currentWeekSoups as $soup):
                                                if($soup["title"] == $userOrderOld[$index]['soup']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo  $selected ?> value="<?php echo $soup["title"] ?>"><?php echo $soup["title"] ?></option>
                                            <?php  
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="salads disable mt-4">
                                <div class="row">
                                    <div class="col">
                                        <label for="<?php echo $weekday ?>Salads">Salads</label>
                                        <select class="form-control" name="<?php echo $weekday ?>Salads" id="<?php echo $weekday ?>Salads">
                                            <option disabled selected value> -- select the salads-- </option>
                                            <?php
                                            $addons = $weekday . "SaladsAddonsFalse";
                                            foreach( $currentWeekSalads as $salad):
                                                if($salad["title"] == $userOrderOld[$index]['salads']):
                                                    $selected = "selected";
                                                else:
                                                    $selected = "";
                                                endif;

                                                if($salad['addons']):
                                                    $addons = $weekday . "SaladsAddonsTrue";
                                                endif;
                                            ?>
                                            <option  <?php echo  $selected ?> class="<?php echo $addons ?>" value="<?php echo $salad["title"] ?>"><?php echo $salad["title"] ?></option>
                                            <?php     
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col">
                                        <label for="<?php echo $weekday ?>SaladsAddons">Salads Addons</label>
                                        <select class="form-control  salads-addons disable" name="<?php echo $weekday ?>SaladsAddons" id="<?php echo $weekday ?>SaladsAddons">
                                            <option disabled selected value> -- select the addon-- </option>
                                            <?php
                                            foreach( $currentWeekSaladsAddons as $saladAddon):
                                                if($saladAddon["title"] == $userOrderOld[$index]['salads_addons']):
                                                    $selected = "selected";
                                                else:
                                                    $selected = "";
                                                endif;
                                            ?>
                                            <option <?php echo  $selected ?> value="<?php echo $saladAddon["title"] ?>"><?php echo $saladAddon["title"] ?></option>
                                            <?php     
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row main-dishes">
                                <div class="col">
                                    <label for="<?php echo $weekday ?>MainDishes">Main Dishes</label>
                                    <select class="form-control" name="<?php echo $weekday ?>MainDishes" id="<?php echo $weekday ?>MainDishes">
                                        <option disabled selected value> -- select the  main dish-- </option>
                                        <?php
                                        $sideDish = $weekday . "SideDishesFalse";
                                        foreach( $currentWeekMainDishes as $mainDish):
                                            if($mainDish["title"] == $userOrderOld[$index]['main_dish']):
                                                $selected = "selected";
                                            else:
                                                $selected = "";
                                            endif;

                                            if($mainDish['side_dish']):
                                                $sideDish = $weekday . "SideDishesTrue";
                                            endif;
                                        ?>
                                        <option <?php echo  $selected ?> class="<?php echo $sideDish ?>" value="<?php echo $mainDish["title"] ?>"><?php echo $mainDish["title"] ?></option>
                                        <?php     
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row disable" id = "<?php echo $weekday ?>SideDishes">
                                <div class="col-6">
                                    <label for="<?php echo $weekday ?>SideDishesHot">Side Dishes Hot</label>
                                    <select class="form-control" name="<?php echo $weekday ?>SideDishesHot" id="<?php echo $weekday ?>SideDishesHot">
                                        <option disabled selected value> -- select hot side dish- </option>
                                        <?php
                                        foreach($currentWeekSideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="hot"):
                                                if($sideDish["title"] == $userOrderOld[$index]['side_dish_hot']):
                                                    $selected = "selected";
                                                else:
                                                    $selected = "";
                                                endif;
                                            ?>
                                            <option <?php echo  $selected ?> value="<?php echo $sideDish["title"] ?>"><?php echo $sideDish["title"] ?></option>
                                            <?php
                                            endif;     
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="<?php echo $weekday ?>SideDishesCold">Side Dishes Cold</label>
                                    <select class="form-control" name="<?php echo $weekday ?>SideDishesCold" id="<?php echo $weekday ?>SideDishesCold">
                                        <option disabled selected value> -- select cold side dish-- </option>
                                        <?php
                                        foreach($currentWeekSideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="cold"):
                                                if($sideDish["title"] == $userOrderOld[$index]['side_dish_cold']):
                                                    $selected = "selected";
                                                else:
                                                    $selected = "";
                                                endif;
                                            ?>
                                            <option <?php echo  $selected ?> value="<?php echo $sideDish["title"] ?>"><?php echo $sideDish["title"] ?></option>
                                            <?php
                                            endif;     
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                    $index++;  
                    endforeach;
                    ?>
                </ul>
                <button class="btn btn-success my-3 p-0" type="submit" name="submit" id="submit">Submit Plans</button>
            </form>       
            <?php
            endif;
            ?>  
            </div>           
        </div>
    </div>
<?php
include "partials/_footer.php";
?>