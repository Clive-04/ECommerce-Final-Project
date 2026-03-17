<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;

class Admin extends BaseController
{

    public function __construct()
    {
        if(!session()->get('logged_in') || session()->get('role') != 'admin')
        {
            header("Location: /login");
            exit;
        }
    }


    // =============================
    // DASHBOARD
    // =============================
    public function index()
    {
        $productModel = new ProductModel();
        $orderModel   = new OrderModel();

        $data['title'] = "VIZIO Admin";

        $data['products_count'] = $productModel->countAll();
        $data['orders_count'] = $orderModel->countAll();

        $revenue = $orderModel->selectSum('total')->first();
        $data['revenue'] = $revenue['total'] ?? 0;

        $data['recent_orders'] = $orderModel
            ->orderBy('order_date','DESC')
            ->findAll(5);

        $data['products'] = $productModel
            ->orderBy('created_at','DESC')
            ->findAll(4);

        return view('admin_view', $data);
    }


    // =============================
    // PRODUCTS PAGE
    // =============================
    public function products()
    {
        $model = new ProductModel();

        $data['title'] = "VIZIO Admin Products";

        $data['products'] = $model
            ->orderBy('created_at','DESC')
            ->findAll();

        return view('adminproducts_view', $data);
    }


    // =============================
    // ADD PRODUCT (WITH IMAGE)
    // =============================
    public function storeProduct()
    {
        $model = new ProductModel();

        $image = $this->request->getFile('image');
        $imagePath = null;

        if ($image && $image->isValid() && !$image->hasMoved())
        {
            $newName = $image->getRandomName();

            // Save to /public/img/
            $image->move(FCPATH . 'img/', $newName);

            $imagePath = 'img/' . $newName;
        }

        $model->save([
            'name'        => $this->request->getPost('name'),
            'sku'         => $this->request->getPost('sku'),
            'brand'       => $this->request->getPost('brand'),
            'category'    => $this->request->getPost('category'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'status'      => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'image'       => $imagePath
        ]);

        return redirect()->to('/admin/products');
    }


    // =============================
    // UPDATE PRODUCT (FIXED + IMAGE)
    // =============================
    public function updateProduct($id)
    {
        $model = new ProductModel();

        $product = $model->find($id);

        $image = $this->request->getFile('image');
        $imagePath = $product['image'];

        // If new image uploaded
        if ($image && $image->isValid() && !$image->hasMoved())
        {
            // Delete old image
            if ($product['image'] && file_exists(FCPATH . $product['image']))
            {
                unlink(FCPATH . $product['image']);
            }

            $newName = $image->getRandomName();
            $image->move(FCPATH . 'img/', $newName);

            $imagePath = 'img/' . $newName;
        }

        $model->update($id, [
            'name'        => $this->request->getPost('name'),
            'sku'         => $this->request->getPost('sku'),
            'brand'       => $this->request->getPost('brand'),
            'category'    => $this->request->getPost('category'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'status'      => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'image'       => $imagePath
        ]);

        return redirect()->to('/admin/products');
    }


    // =============================
    // DELETE PRODUCT (WITH IMAGE DELETE)
    // =============================
    public function deleteProduct($id)
    {
        $model = new ProductModel();

        $product = $model->find($id);

        // Delete image file
        if ($product['image'] && file_exists(FCPATH . $product['image']))
        {
            unlink(FCPATH . $product['image']);
        }

        $model->delete($id);

        return redirect()->to('/admin/products');
    }


    // =============================
    // ORDERS PAGE
    // =============================
    public function orders()
    {
        $orderModel = new OrderModel();

        $data['title'] = "VIZIO Admin Orders";

        $data['orders'] = $orderModel
            ->orderBy('order_date','DESC')
            ->findAll();

        return view('adminorders_view', $data);
    }

}
