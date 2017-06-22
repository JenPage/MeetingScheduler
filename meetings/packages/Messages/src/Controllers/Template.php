<?php
//things are the same from class to class

abstract class Sub{


    public function make()
    {
        return $this
            ->layBread()
            ->addLettuce()
            ->addPrimaryToppings()
            ->addSauces();
    }

    protected function layBread()
    {
        var_dump('laying bread');

        return $this;
    }

    protected function addLettuce()
    {
        var_dump('lettuce');
        return $this;
    }

    public function addSauces()
    {
        var_dump('sauces');
        return $this;
    }

    protected abstract function addPrimaryToppings();

}
class TurkeySub extends Sub{

    protected function addPrimaryToppings()
    {
        var_dump('turkey');
        return $this;
    }
}
class VeggieSub extends Sub{

    public function addPrimaryToppings()
    {
        var_dump('veggies');
        return $this;
    }

}
(new VeggieSub())->make();