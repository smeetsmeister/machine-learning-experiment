<?php

class classifier
{
    const NOT_ENOUGH_DATA_ERROR = "Not enough training data received.";
    private $products;

    public function __construct()
    {
        $this->products = [];
    }

    /**
     * Function to 'train' the machine, give it data so it can calculate the propability of orders later.
     *
     * @param $product String of Product name which has been ordered
     * @param $others Array with strings of product names of other products in order.
     */
    public function train($product, $others)
    {
        //if the product has not been ordered yet, order it.
        if (!in_array($product, $this->products)) {
            $this->products[$product] = [];
        }

        //loop through other products in this order and add them to the first product.
        foreach ($others as $other) {
            //if this product has not been ordered with this other product, set its count to one.
            if (!array_key_exists($other, $this->products[$product])) {
                $this->products[$product][$other] = 1;
            } else {
                //if its ordered before increase it by one.
                $this->products[$product][$other] ++;
            }
        }
    }


    /**
     * TODO: Move to own class.
     *
     * Function to train with an order, this needs to be done so 'others' know of the first product.
     *
     * @param $order array of product names
     */
    public function OrderToTrain($order)
    {
        $combinations = [];
        $count = 0;

        //loop through all products in an order
        foreach ($order as $key => $value)
        {
            //create list of others.
            $others = [];

            // Loop again through the rest of the array.
            foreach ($order as $key2 => $value2) {
                //if the key is not the same add it to others.
                if($key2 !=  $key)
                {
                    $others[] = $value2;
                }
            }

            // Train it with the data.
            $this->train($value, $others);


        }
    }

    /**
     * calculate the probability of the other products being orded with this product.
     *
     * @param $product String of Product name which has been ordered
     */
    public function categorize($product) : string
    {
        //first check if product is trained at least once
        if(!array_key_exists($product, $this->products)){
            return self::NOT_ENOUGH_DATA_ERROR;
        }

        //get the total of products that have been ordered together with this product.
        $total = 0;
        foreach ($this->products[$product] as $products) {
            $total += $products;
        }

        //calculate what product has the most chance to be ordered.
        $largestCount = 0;
        $largestProduct = "";
        foreach ($this->products[$product] as $key => $value) {
            if($value > $largestCount)
            {
                $largestCount = $value;
                $largestProduct = $key;
            }
        }

        return $largestProduct;
    }
}