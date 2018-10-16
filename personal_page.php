<?php
include "partials/_header.php";
include "functions.php";
session_start();
if(isset($_POST["submit"])):
    updateUserOrder();
endif;
if(!isset($_SESSION['username'])):
    $_SESSION['message'] = "Please Login!!!";
    header('location: index.php?login=failed');
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
                            <th class="text-nowrap" scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentWeekData;
                        foreach($weekDays as $weekDay):
                            foreach($userData as $data):
                                if($data['week_day'] == $weekDay):
                                    $currentDayData = $data;
                                endif;  
                            endforeach;
                            ?>
                            <tr>
                                <td><?php echo ucfirst($weekDay) ?></td>
                                <td>
                                    <?php
                                    if($currentDayData['soup'] != "NULL"):
                                        echo $currentDayData['soup'] . " " . $currentDayData['soup_price'] . "eur";
                                    else:
                                        echo "-";
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($currentDayData['salads'] != "NULL"):
                                        echo $currentDayData['salads'] . " " .  $currentDayData['salads_price'] . "eur";
                                    else:
                                        echo "-";
                                    endif;
                                    ?>
                                </td>
                                <td>  
                                    <?php
                                    if($currentDayData['salads_addons'] != "NULL"):
                                        echo $currentDayData['salads_addons'] . " " .  $currentDayData['salads_addons_price'] . "eur";
                                    else:
                                        echo "-";
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($currentDayData['main_dish'] != "NULL"):
                                        echo $currentDayData['main_dish'] . " " .  $currentDayData['main_dish_price'] . "eur";
                                    else:
                                        echo "-";
                                    endif;
                                    ?>   
                                </td>
                                <td>
                                    <?php
                                    if($currentDayData['side_dish_hot'] != "NULL"):
                                        echo $currentDayData['side_dish_hot'];
                                    else:
                                        echo "-";
                                    endif;
                                    ?>  
                                </td>
                                <td>
                                    <?php
                                    if($currentDayData['side_dish_cold'] != "NULL"):
                                        echo $currentDayData['side_dish_cold'];
                                    else:
                                        echo "-";
                                    endif;
                                    ?> 
                                </td>
                                <td>
                                    <?php
                                    echo $currentDayData['total_price'] . " eur";
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
                    $soups = getSoups();
                    $salads = getSalads();
                    $saladsAddons = getSaladsAddons();
                    $mainDishes = getMainDishes();
                    $sideDishes = getSideDishes();

                    foreach($weekDays as $weekday):   
                        $currentDaySoups = getCurrentDayDishOptions($soups, $weekday); 
                        $currentDaySalads = getCurrentDayDishOptions($salads, $weekday);
                        $currentDaySaladsAddons = getCurrentDayDishOptions($saladsAddons, $weekday);
                        $currentDayMainDishes = getCurrentDayDishOptions($mainDishes, $weekday);
                        $currentDaySideDishes = getCurrentDayDishOptions($sideDishes, $weekday);
                    ?>
                    <li class="list-group-item" id="<?php echo $weekday ?>">
                            <h2><?php echo ucfirst($weekday) ?></h2>
                        <div class="form-group">
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="d-flex  align-items-center">
                                        <p class="m-0 pr-2">Soup</p>
                                        <label class="switch m-0" id="<?php echo $weekday ?>Switch">
                                            <input type="checkbox">
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
                                            foreach( $currentDaySoups as $soup):
                                            ?>
                                            <option value="<?php echo $soup["title"] . "_{$soup['price']}" ?>">
                                                <?php echo $soup["title"] . ". Price: {$soup['price']} eur"?>
                                            </option>
                                            <?php  
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="salads disable mt-4">
                                <div class="salads-select row">
                                    <div class="col">
                                        <label for="<?php echo $weekday ?>Salads">Salads</label>
                                        <select class="form-control" name="<?php echo $weekday ?>Salads" id="<?php echo $weekday ?>Salads">
                                            <option disabled selected value> -- select the salads-- </option>
                                            <?php
                                            $addons = $weekday . "SaladsAddonsFalse";
                                            foreach( $currentDaySalads as $salad):
                                                if($salad['addons']):
                                                    $addons = $weekday . "SaladsAddonsTrue";
                                                endif;
                                            ?>
                                            <option class="<?php echo $addons ?>" value="<?php echo $salad["title"] . "_{$salad['price']}" ?>">
                                                <?php echo $salad["title"] . " ({$salad['price']} eur)"?>
                                            </option>
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
                                            foreach( $currentDaySaladsAddons as $saladAddon):
                                            ?>
                                            <option value="<?php echo $saladAddon["title"] . "_{$saladAddon['price']}"?>">
                                                <?php echo $saladAddon["title"] . " ({$saladAddon['price']} eur)"?>
                                            </option>
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
                                        foreach( $currentDayMainDishes as $mainDish):
                                            if($mainDish['side_dish']):
                                                $sideDish = $weekday . "SideDishesTrue";
                                            endif;
                                        ?>
                                        <option class="<?php echo $sideDish ?>" value="<?php echo $mainDish["title"] . "_{$mainDish['price']}"?>">
                                            <?php echo $mainDish["title"] . " ({$mainDish['price']} eur)"?>
                                        </option>
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
                                        foreach($currentDaySideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="hot"):
                                            ?>
                                            <option value="<?php echo $sideDish["title"] ?>">
                                                <?php echo $sideDish["title"]?>
                                            </option>
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
                                        foreach($currentDaySideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="cold"):
                                            ?>
                                            <option value="<?php echo $sideDish["title"] ?>">
                                                <?php echo $sideDish["title"]?>
                                            </option>
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