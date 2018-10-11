<?php
include "partials/_header.php";
include "inclusions/_inc_functions.php";
include "functions.php";
session_start();
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
                <li class="list-group-item" id="monday">
                    <h2>Monday</h2>
                    <form class="p-0">
                        <div class="form-group">
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="d-flex  align-items-center">
                                        <p class="m-0 pr-2">Soup</p>
                                        <label class="switch m-0" id="mondaySwitch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="m-0 pl-2">Salads</p>
                                    </div>
                                </div>
                            </div>
                            <div class="soup mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="mondaySoups">Soups</label>
                                        <select class="form-control" id="mondaySoups">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="salads disable mt-4">
                                <div class="row">
                                    <div class="col">
                                        <label for="mondaySalads">Salads</label>
                                        <select class="form-control" id="mondaySalads">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="mondaySaladsAddons">Salads Addons</label>
                                        <select class="form-control" id="mondaySaladsAddons">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="mondayMainDishes">Main Dishes</label>
                                    <select class="form-control" id="mondayMainDishes">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="mondaySideDishesHot">Side Dishes Hot</label>
                                    <select class="form-control" id="mondaySideDishesHot">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="mondaySideDishesCold">Side Dishes Cold</label>
                                    <select class="form-control" id="exampleFormControlCold">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </form>
                </li>
                <li class="list-group-item" id="thuesday">
                    <h2>Monday</h2>
                    <form class="p-0">
                        <div class="form-group">
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="d-flex  align-items-center">
                                        <p class="m-0 pr-2">Soup</p>
                                        <label class="switch m-0" id="thuesdaySwitch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                        <p class="m-0 pl-2">Salads</p>
                                    </div>
                                </div>
                            </div>
                            <div class="soup mt-4">
                                <p class="p-0">Soups</p>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="salads disable mt-4">
                                <p>Salads</p>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label for="exampleFormControlSelect1">Example select</label>
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </form>
                </li>
            </ul>


            <a href="personal_page.php?delete=true" class="btn btn-danger">Delete Plans</a>
            <a href="personal_page.php?update=true" class="btn btn-success">Update Plans</a>
            
            <?php
            if(isset($_GET["update"])):
                updateMealPlans();
            endif;
            ?>
             <?php
            if(isset($_GET["delete"])):
                clearTables();
            endif;
            ?>
        
            </div>           
        </div>
    </div>

<?php
include "partials/_footer.php";
?>