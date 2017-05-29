<?php 


spl_autoload_register(function ($class_name) {
    include 'Models/'.$class_name . '.php';
});







$category = new Category('1','Roupa');

$prod[] = new Product('1','Calças',$category,'10£');

$prod[] = new Product('2','T-shirt',$category,'5s£');


$cost1 = new Costumer('1','André');

$ordem = new Order('1',$cost1,$prod,'20.00');
echo '<pre>';
print_r($ordem);


 ?>