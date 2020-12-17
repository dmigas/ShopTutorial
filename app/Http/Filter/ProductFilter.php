<?php

namespace App\Http\Filter;

class ProductFilter extends QueryFilter {

    public function popular(){ #example.com/products?popular=true
        #return $this->builder->orderBy('created_at', $order);
    }

    public function latest(){
        return $this->builder->orderBy('created_at', 'DESC');
    }

    public function q(){
        return $this->builder->where('name', 'LIKE', '%' . $this->request->q. '%');
    }
}
