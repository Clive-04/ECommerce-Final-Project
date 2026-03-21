<?php
namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'created_at'];

    // Get or create cart for user
        public function getOrCreateCart($userId)
    {
        $cart = $this->where('user_id', $userId)->first();
        if ($cart) {
            return $cart['id'];
        }
        // Create new cart
        $this->insert(['user_id' => $userId]);
        return $this->getInsertID();
    }
    }


class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cart_id', 'product_id', 'quantity', 'added_at'];

    // Add item to cart
    public function addItem($cartId, $productId, $quantity = 1)
    {
        $item = $this->where(['cart_id' => $cartId, 'product_id' => $productId])->first();
        if ($item) {
            // Update quantity
            $this->update($item['id'], ['quantity' => $item['quantity'] + $quantity]);
        } else {
            // Insert new item
            $this->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }

    // Get all items in cart
    public function getCartItems($cartId)
    {
        return $this->where('cart_id', $cartId)->findAll();
    }

    // Update item quantity in cart
    public function updateItem($cartId, $productId, $quantity)
    {
        $item = $this->where(['cart_id' => $cartId, 'product_id' => $productId])->first();
        if ($item) {
            $this->update($item['id'], ['quantity' => $quantity]);
        }
    }

    // Remove item from cart
    public function removeItem($cartId, $productId)
    {
        $item = $this->where(['cart_id' => $cartId, 'product_id' => $productId])->first();
        if ($item) {
            $this->delete($item['id']);
        }
    }
}
