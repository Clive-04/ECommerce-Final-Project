<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        $role = strtolower(session()->get('role') ?? '');
        if (! session()->get('logged_in') || $role !== 'admin') {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'VIZIO Admin';
        $data['adminName'] = session()->get('user_name') ?? 'Admin';

        $orderModel = new \App\Models\OrderModel();
        $productModel = new \App\Models\ProductModel();
        $orderItemModel = new \App\Models\OrderItemModel();

        // Dashboard stats
        $totalRevenueRow = $orderModel->selectSum('total')->first();
        $data['totalRevenue'] = (float) ($totalRevenueRow['total'] ?? 0);

        $data['totalOrders'] = (new \App\Models\OrderModel())->countAllResults();
        $data['pendingOrders'] = (new \App\Models\OrderModel())
            ->where('status', 'Pending')
            ->countAllResults();
        $data['totalProducts'] = $productModel->countAllResults();
        $data['lowStockCount'] = (new \App\Models\ProductModel())
            ->where('stock <', 10)
            ->countAllResults();

        // Recent orders
        $recentOrders = (new \App\Models\OrderModel())
            ->orderBy('order_date', 'DESC')
            ->findAll(4);

        $data['recentOrders'] = [];
        foreach ($recentOrders as $order) {
            $orderItems = (new \App\Models\OrderItemModel())
                ->where('order_id', $order['id'])
                ->orderBy('id', 'ASC')
                ->findAll(1);

            $productName = '';
            if (! empty($orderItems)) {
                $product = $productModel->find($orderItems[0]['product_id']);
                $productName = $product['name'] ?? '';
            }

            $data['recentOrders'][] = [
                'order_number' => $order['id'],
                'product' => $productName,
                'status' => $order['status'],
            ];
        }

        // Top products by quantity sold
        $topProducts = $orderItemModel
            ->select('product_id, SUM(quantity) AS sold_qty')
            ->groupBy('product_id')
            ->orderBy('sold_qty', 'DESC')
            ->findAll(4);

        $data['topProducts'] = [];
        foreach ($topProducts as $row) {
            $product = $productModel->find($row['product_id']);
            if (! $product) {
                continue;
            }

            $data['topProducts'][] = [
                'name' => $product['name'],
                'soldQty' => (int) $row['sold_qty'],
            ];
        }

        // Sales overview for the last 7 days, reordered Sunday to Saturday
        $salesRows = (new \App\Models\OrderModel())
            ->select('DATE(order_date) AS sale_date, SUM(total) AS total_sales', false)
            ->where('order_date >=', date('Y-m-d 00:00:00', strtotime('-6 days')))
            ->groupBy('DATE(order_date)')
            ->orderBy('sale_date', 'ASC')
            ->findAll();

        $salesMap = [];
        foreach ($salesRows as $row) {
            $salesMap[$row['sale_date']] = (float) $row['total_sales'];
        }

        $orderedDays = [
            'Sun' => 0,
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thu' => 0,
            'Fri' => 0,
            'Sat' => 0,
        ];

        foreach ($salesMap as $date => $amount) {
            $label = date('D', strtotime($date));
            if (array_key_exists($label, $orderedDays)) {
                $orderedDays[$label] += $amount;
            }
        }

        $data['salesOverview'] = [];
        $maxSales = max($orderedDays);

        foreach ($orderedDays as $label => $amount) {
            $data['salesOverview'][] = [
                'label' => $label,
                'date' => $label,
                'amount' => $amount,
                'height' => $maxSales > 0
                    ? max(12, round(($amount / $maxSales) * 100, 2))
                    : 12,
            ];
        }
        return view('admin_view', $data);
    }

    public function products()
    {
        $data['title'] = 'VIZIO Admin Products';

        return view('adminproducts_view', $data);
    }

    public function orders()
    {
        $data['title'] = 'VIZIO Admin Orders';

        $search = trim($this->request->getGet('search') ?? '');
        $data['search'] = $search;

        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $userModel = new \App\Models\UserModel();

        $orderQuery = $orderModel->select('orders.*')
            ->join('users', 'users.id = orders.user_id', 'left');

        if ($search !== '') {
            $orderQuery = $orderQuery->groupStart();

            if (preg_match('/^\s*#?ORD-?(\d+)\s*$/i', $search, $m)) {
                $orderQuery = $orderQuery->where('orders.id', (int) $m[1]);
            } elseif (ctype_digit($search)) {
                $orderQuery = $orderQuery->where('orders.id', (int) $search);
            }

            $orderQuery = $orderQuery
                ->orLike('users.first_name', $search)
                ->orLike('users.last_name', $search)
                ->groupEnd();
        }

        $orders = $orderQuery->orderBy('orders.order_date', 'DESC')->findAll(50);

        $data['orders'] = [];
        foreach ($orders as $order) {
            $user = $userModel->find($order['user_id']);
            $customerName = $user ? trim($user['first_name'] . ' ' . $user['last_name']) : 'Unknown';

            $itemsData = $orderItemModel->selectSum('quantity', 'itemCount')
                ->where('order_id', $order['id'])
                ->first();

            $data['orders'][] = [
                'id' => $order['id'],
                'customer' => $customerName,
                'items' => (int) ($itemsData['itemCount'] ?? 0),
                'total' => (float) $order['total'],
                'status' => $order['status'],
                'date' => $order['order_date'],
            ];
        }

        $data['orderCount'] = count($data['orders']);

        return view('adminorders_view', $data);
    }

    public function viewOrder($id)
    {
        $orderModel = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $userModel = new \App\Models\UserModel();

        $order = $orderModel->find($id);
        if (! $order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $user = $userModel->find($order['user_id']);
        $customerName = $user ? trim($user['first_name'] . ' ' . $user['last_name']) : 'Unknown';
        $customerEmail = $user['email'] ?? '';
        $customerId = $user['id'] ?? null;

        $items = $orderItemModel
            ->select('order_items.*, products.name as product_name')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->where('order_items.order_id', $order['id'])
            ->findAll();

        $data = [
            'title' => "Order #{$order['id']}",
            'adminName' => session()->get('user_name') ?? 'Admin',
            'order' => $order,
            'customerName' => $customerName,
            'customerEmail' => $customerEmail,
            'customerId' => $customerId,
            'items' => $items,
            'itemCount' => count($items),
        ];

        return view('adminorder_detail_view', $data);
    }

    public function exportOrders($format = 'csv')
    {
        $format = strtolower($format);
        $search = trim($this->request->getGet('search') ?? '');

        $orderModel = new \App\Models\OrderModel();
        $userModel = new \App\Models\UserModel();
        $orderItemModel = new \App\Models\OrderItemModel();

        $orderQuery = $orderModel->select('orders.*')
            ->join('users', 'users.id = orders.user_id', 'left');

        if ($search !== '') {
            $orderQuery = $orderQuery->groupStart();

            if (preg_match('/^\s*#?ORD-?(\d+)\s*$/i', $search, $m)) {
                $orderQuery = $orderQuery->where('orders.id', (int) $m[1]);
            } elseif (ctype_digit($search)) {
                $orderQuery = $orderQuery->where('orders.id', (int) $search);
            }

            $orderQuery = $orderQuery
                ->orLike('users.first_name', $search)
                ->orLike('users.last_name', $search)
                ->groupEnd();
        }

        $orders = $orderQuery->orderBy('orders.order_date', 'DESC')->findAll();

        $rows = [];
        foreach ($orders as $order) {
            $user = $userModel->find($order['user_id']);
            $customerName = $user ? trim($user['first_name'] . ' ' . $user['last_name']) : 'Unknown';

            $itemsData = $orderItemModel->selectSum('quantity', 'itemCount')
                ->where('order_id', $order['id'])
                ->first();

            $rows[] = [
                'Order ID' => $order['id'],
                'Customer' => $customerName,
                'Items' => (int) ($itemsData['itemCount'] ?? 0),
                'Total' => number_format($order['total'], 2),
                'Status' => $order['status'],
                'Date' => $order['order_date'],
            ];
        }

        if ($format === 'pdf') {
            $html = '<h1>Orders Export</h1>';
            $html .= "<table border='1' cellpadding='5' cellspacing='0'>";
            $html .= '<tr>';

            foreach (array_keys($rows[0] ?? []) as $col) {
                $html .= '<th>' . htmlspecialchars($col, ENT_QUOTES, 'UTF-8') . '</th>';
            }

            $html .= '</tr>';

            foreach ($rows as $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    $html .= '<td>' . htmlspecialchars((string) $cell, ENT_QUOTES, 'UTF-8') . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</table>';

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="orders.pdf"')
                ->setBody($html);
        }

        $filename = 'orders_export_' . date('Ymd_His');
        $ext = $format === 'xls' ? 'xls' : 'csv';
        $contentType = $format === 'xls'
            ? 'application/vnd.ms-excel'
            : 'text/csv';

        $fp = fopen('php://temp', 'r+');
        if (! empty($rows)) {
            fputcsv($fp, array_keys($rows[0]));
            foreach ($rows as $row) {
                fputcsv($fp, array_values($row));
            }
        }
        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '.' . $ext . '"')
            ->setBody($csv);
    }
}
