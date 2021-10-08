<?php

    class Foo {
        public $aMemberVar = 'Something';
        public $aFuncName = 'aMemberfunc';

        function aMemberFunc(){
            print 'Inside "aMemberfunc()"';
        }
    }
    $foo = new Foo;

    class Person{
        private $name;

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
    }
    $john = new Person();

    $john->setName("John Wick");
    echo "My name is " . $john->getName() . "\n</br>";

    class Entree {
        public $name;
        public $ingredients = array();

        public function hasIngredient($ingredient){
            return in_array($ingredient, $this->ingredients);
        }

        public static function getSizes(){
            return array('small', 'medium', 'large');
        }
    }

    $soup = new Entree;
    $soup->name = 'Chicken Soup';
    $soup->ingredients = array('chicken', 'water');

    foreach(['chicken', 'lemon', 'pepper', 'water'] as $ing){
        if($soup->hasIngredient($ing)){
            print "Soup contains $ing \n</br>";
        }
    }

    //static stuff
    $sizes = Entree::getSizes();


    //constructor
    class Main {
        public $name;
        public $ingredients = array();

        public function __construct($name, $ingredients){
            $this->name = $name;
            $this->ingredients = $ingredients;
        }
       

        public function hasIngredient($ingredient){
            return in_array($ingredient, $this->ingredients);
        }

        public static function getSizes(){
            return array('small', 'medium', 'large');
        }
    }

    $alfredo = new Main('Alfredo', array("chicken", "alfredo"));
    $soupMain = new Main('soup', array("chicken", "water"));


    class ComboMeal extends Main{
        //custom constructor, you can skip it. if you make no changes
        public function __construct($name, $mains){
            parent::__construct($name, $mains);
            foreach($mains as $main){
                if(! $main instanceof Main){
                    throw new Exception('Elements of $mains must be Main objects');
                }
            }
        }


        public function hasIngredient($ing){
            foreach($this->ingredients as $entree){
                if($entree->hasIngredient($ing)){
                    return true;
                }
            }
            return false;
        }
    }

    $combo = new ComboMeal("alfredo + soup", array($alfredo, $soupMain));
    echo $combo->name . "</br>";

    foreach(['chicken', 'lemon', 'alfredo', 'water'] as $ing){
        if($combo->hasIngredient($ing)){
            print "Something in the combo contains $ing \n</br>";
        }
    }


    //we can use public, private, 
    //private is not accesible to sublcass
    //protected, protected means only subclass can access it
?>
