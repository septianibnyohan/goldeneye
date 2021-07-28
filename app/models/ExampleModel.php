<?php
class ExampleModel extends DModel {

    function __construct() {

    }

    public function catList() {
        return array(
            array(
                'catOne' => 'Education',
                'catTwo' => 'Sports',
                'catThree' => 'Health'
            ),
            array(
                'catOne' => 'Education',
                'catTwo' => 'Sports',
                'catThree' => 'Health'
            )
        );
    }

}
?>