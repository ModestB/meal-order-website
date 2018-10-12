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
        <div class="container d-flex justify-content-center align-items-center">
            <div class="personal-page d-flex flex-column">
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
            <ul class="list-group">
                <?php 
                $weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday'];
                foreach($weekDays as $weekday):
                ?>
                <li class="list-group-item" id="<?php echo $weekday ?>">
                    <h2><?php echo ucfirst($weekday) ?></h2>
                    <form class="p-0">
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
                                        <select class="form-control" id="<?php echo $weekday ?>Soups">
                                            <option disabled selected value> -- select the soup-- </option>
                                            <?php
                                            $soups = getSoups($weekday);
                                            foreach($soups as $soup):
                                            ?>
                                            <option><?php echo $soup["title"] ?></option>
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
                                        <select class="form-control" id="<?php echo $weekday ?>Salads">
                                            <option disabled selected value> -- select the salads-- </option>
                                        <?php
                                            $salads = getSalads($weekday);
                                            $addons = $weekday . "SaladsAddonsFalse";
                                            foreach($salads as $salad):
                                                if($salad['addons']):
                                                    $addons = $weekday . "SaladsAddonsTrue";
                                                endif;
                                            ?>
                                            <option class="<?php echo $addons ?>"><?php echo $salad["title"] ?></option>
                                            <?php     
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">    
                                    <div class="col">
                                        <label for="<?php echo $weekday ?>SaladsAddons">Salads Addons</label>
                                        <select class="form-control  salads-addons disable" id="<?php echo $weekday ?>SaladsAddons">
                                        <?php
                                            $saladsAddons = getSaladsAddons($weekday);
                                            foreach($saladsAddons as $saladAddon):
                                            ?>
                                            <option><?php echo $saladAddon["title"] ?></option>
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
                                    <select class="form-control" id="<?php echo $weekday ?>MainDishes">
                                        <option disabled selected value> -- select the  main dish-- </option>
                                    <?php
                                        $mainDishes = getMainDishes($weekday);
                                        $sideDish = $weekday . "SideDishesFalse";
                                        
                                        foreach($mainDishes as $mainDish):
                                            if($mainDish['side_dish']):
                                                $sideDish = $weekday . "SideDishesTrue";
                                            endif;
                                        ?>
                                        <option class="<?php echo $sideDish ?>"><?php echo $mainDish["title"] ?></option>
                                        <?php     
                                        endforeach;
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row disable" id = "<?php echo $weekday ?>SideDishes">
                                <div class="col-6">
                                    <label for="<?php echo $weekday ?>SideDishesHot">Side Dishes Hot</label>
                                    <select class="form-control" id="<?php echo $weekday ?>SideDishesHot">
                                    <?php
                                        $sideDishes = getSideDishes($weekday);
                                        foreach($sideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="hot"):
                                            ?>
                                            <option><?php echo $sideDish["title"] ?></option>
                                            <?php
                                            endif;     
                                        endforeach;
                                    ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="<?php echo $weekday ?>SideDishesCold">Side Dishes Cold</label>
                                    <select class="form-control" id="<?php echo $weekday ?>SideDishesCold">
                                    <?php
                                        $sideDishes = getSideDishes($weekday);
                                        foreach($sideDishes as $sideDish):
                                            if($sideDish["dish_type"]=="cold"):
                                            ?>
                                            <option><?php echo $sideDish["title"] ?></option>
                                            <?php
                                            endif;     
                                        endforeach;
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
                <?php
                endforeach;
                ?>
            </ul>

            <!-- <a href="personal_page.php?delete=true" class="btn btn-danger">Delete Plans</a> -->
            <a href="personal_page.php?delete=true" class="btn btn-success">Update Plans</a>
            
            </div>           
        </div>
    </div>

<?php
include "partials/_footer.php";
?>