<?php

class Model_wishlist extends CI_Model {

    function getWishlistByUserId($user_id, $sort_by = '', $order_by = 'desc') {
        $this->db->where('user_id', $user_id);
        if ($sort_by)
            $this->db->order_by($sort_by, $order_by);
            //$this->db->order_by("CAST( $sort_by AS signed )", $order_by);
        $list = $this->db->get('wishlist')->result_array();

        if ($list)
            return $list;

        return false;
    }

    function getWishlistByLogin($login, $sort_by = '', $order_by = 'desc') {
        $this->db->select('id');
        $this->db->where('login', $login);
        $this->db->limit(1);
        $user_id = $this->db->get('users')->result_array();
        
        if ($sort_by)
            $this->db->order_by($sort_by, $order_by);
            //$this->db->order_by("CAST( $sort_by AS signed )", $order_by);
        $this->db->where('user_id', $user_id[0]['id']);
        $list = $this->db->get('wishlist')->result_array();

        if ($list)
            return $list;

        return false;
    }

    function delFromWishlist($product, $user_id) {

        $this->db->where('user_id', $user_id);
        if (is_array($product)) {
            $this->db->where('product_id', $product[0]);
            for ($i = 1; $i < count($product); $i++) {
                $this->db->or_where('product_id', $product[0]);
            }
        } else {
            $this->db->where('product_id', $product);
        }

        if ($this->db->delete('wishlist'))
            return true;

        return false;
    }

    function addToWishlist($product, $user_id) {

        $this->db->select('id');
        $this->db->where('product_id', $product['id']);
        $this->db->where('user_id', $user_id);
        if ($this->db->get('wishlist')->num_rows) {
            $data = array(
                'price' => $product['price'],
                'in_warehouse' => $product['in_warehouse']
            );

            $this->db->where('product_id', $product['id']);
            $this->db->where('user_id', $user_id);
            if ($this->db->update('wishlist', $data))
                return true;
        } else {
            $data = array(
                'user_id' => $user_id,
                'product_id' => $product['id'],
                'price' => $product['price'],
                'in_warehouse' => $product['in_warehouse']
            );

            if ($this->db->insert('wishlist', $data))
                return true;
        }
        
        return false;
    }

    function inWishlist($product, $user_id) {
        $this->db->select('id');
        $this->db->where('product_id', $product['id']);
        $this->db->where('user_id', $user_id);

        if ($this->db->get('wishlist')->num_rows) 
            return true;

        return false;
        
    }
    /*
    function sendMailByProductInWishlist($prod_id) {
        $mails = $this->db->query("SELECT u.email, p.category_id, p.name, p.price "
                        ."FROM  users u, wishlist wl, products p "
                        ."WHERE wl.user_id = u.id AND wl.product_id = p.id "
                            ."AND wl.product_id = $prod_id")->result_array();
        if ($mails) {
            
        }
        
    }
    */
}
