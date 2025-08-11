<?php
namespace App\Controllers\admin;
use Razorpay\Api\Api;
use Dompdf\Dompdf;

class OrderListController extends BaseController
{
    private $apiKey;
    private $apiSecret;
    private $api;

    public function __construct()
    {
        $this->apiKey = $_ENV['RAZORPAY_KEY_ID'];
        $this->apiSecret = $_ENV['RAZORPAY_KEY_SECRET'];

        $this->api = new Api($this->apiKey, $this->apiSecret);
    }

    public function orderList()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view("admin/orderList");
        }
    }

    public function getOrderList()
    {
        $db = \Config\Database::connect();
        $query =
            "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date ,  DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS deliverydate
            FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND b.flag = 1 AND a.order_status <> 'initiated' AND  a.payment_status <> 'PENDING'";
        $orderDetail = $db->query($query)->getResultArray();



        echo json_encode($orderDetail);
    }

    public function getOrderDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost('order_id');

        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();


        $data = [];

        for ($i = 0; $i < count($itemDetails); $i++) {

            $prodID = $itemDetails[$i]['prod_id'];
            $tableName = $itemDetails[$i]['table_name'];
            $color = $itemDetails[$i]['color'];
            $hexCode = $itemDetails[$i]['hex_code'];
            $size = $itemDetails[$i]['size'];
            $mrp = $itemDetails[$i]['mrp'];
            $offerPrice = $itemDetails[$i]['offer_price'];
            $offerType = $itemDetails[$i]['offer_type'];
            $offerDetails = $itemDetails[$i]['offer_details'];


            $itemQuery = "SELECT 
                a.order_id, a.order_no, a.sub_total, a.courier_charge, a.order_status, 
                a.log AS order_time, a.order_date, a.razerpay_payment_id, a.payment_status, 
                a.delivery_status, a.cancel_reason, a.courier_type,
                b.quantity, b.prod_price, b.sub_total AS product_price, 
                b.color, b.hex_code, b.size, b.config_image1, b.color_name, 
                c.product_name, c.product_img, c.stock_status,c.drop_shipping,
                d.*, e.state_title, f.dist_name, 
                g.number, g.username, g.email
            FROM 
                tbl_orders AS a 
            LEFT JOIN 
                tbl_order_item AS b ON a.order_id = b.order_id 
            INNER JOIN 
                $tableName AS c ON b.prod_id = c.prod_id
            INNER JOIN 
                tbl_user_address AS d ON a.add_id = d.add_id
            INNER JOIN 
                tbl_state AS e ON e.state_id = d.state_id
            INNER JOIN 
                tbl_district AS f ON f.dist_id = d.dist_id
            INNER JOIN 
                tbl_users AS g ON g.user_id = d.user_id
            WHERE 
                d.default_addr = 1 
                AND d.flag = 1 
                AND b.order_id = ? 
                AND c.prod_id = ? 
                AND c.flag = 1 
                AND a.flag = 1 
                AND b.color = ? 
                AND b.hex_code = ? 
                AND b.size = ?
        ";


            $itemRes = $db->query($itemQuery, [$orderID, $prodID, $color, $hexCode, $size])->getRowArray();



            if ($itemRes) {
                $itemRes['actual_price'] = $mrp;
                $itemRes['offer_price'] = $offerPrice;
                $itemRes['offer_type'] = $offerType;
                $itemRes['offer_details'] = $offerDetails;
                $data[] = $itemRes;
            }

        }


        $orderSummaries[$orderID] = $data;



        $res = $orderSummaries[$orderID];


        echo json_encode($res);

    }

    public function deleteOrderDetails()
    {
        $db = \Config\Database::connect();

        $orderID = $this->request->getPost('order_id');



        $query = "UPDATE tbl_orders SET `flag` = 0 WHERE `order_id` = ?";
        $dltData = $db->query($query, $orderID);

        $affectedRows = $db->affectedRows();

        if ($dltData && $affectedRows) {
            $result['code'] = 200;
            $result['msg'] = 'Product Deleted!!';
            $result['status'] = 'success';


            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';

            echo json_encode($result);
        }
    }

    function updateTrackingDetails()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getpost();


        $deliveryDate = $this->request->getpost('delivery_date');
        $courierPartner = $this->request->getpost('courier_partner');
        $trackingID = $this->request->getpost('tracking_id');
        $couponCode = $this->request->getpost('coupon_code');
        $orderId = $this->request->getpost('order_id');
        $bill_no = $this->request->getpost('bill_no');
        $bill_date = $this->request->getpost('bill_date');



        $query = "UPDATE tbl_orders SET delivery_date=?, courier_partner = ? ,tracking_id = ?,coupon_code = ?,bill_no = ?,bill_date = ?
                  WHERE order_id  = ? AND flag  = 1";
        $updateOrder = $db->query($query, [$deliveryDate, $courierPartner, $trackingID, $couponCode, $bill_no, $bill_date, $orderId]);
        $affectedRows = $db->affectedRows();


        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);

    }

    public function getTrackingDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("order_id");

        $query = "SELECT  `delivery_date` ,`delivery_message` , `courier_partner` ,`bill_no`,`bill_date`,
                  `tracking_id` , `coupon_code`  FROM `tbl_orders` WHERE `flag` = 1 AND `order_id` = ?";

        $res['track_detail'] = $db->query($query, [$orderID])->getResultArray();

        $res['code'] = 200;
        $res['status'] = 'success';

        echo json_encode($res);
    }


    public function viewTrackingDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("order_id");

        $query = "SELECT  `delivery_date` ,`delivery_message` , `courier_partner` , `bill_no`,
        `bill_date`,  `tracking_id` , `coupon_code`  FROM `tbl_orders`
         WHERE `flag` = 1 AND `order_id` = ?";


        $res = $db->query($query, [$orderID])->getResultArray();
        echo json_encode($res);

    }


    public function updateCancelReason()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getPost();

        $delivery_status = $this->request->getPost('delivery_status');
        $order_id = $this->request->getPost('order_id');
        $cancelReason = $this->request->getPost('cancelReason');
        $delivery_message = 6;


        $query = "UPDATE tbl_orders SET 
                    delivery_status = ?, 
                    delivery_message = ?,
                    cancel_rea3        son = ?";

        $params = [$delivery_status, $delivery_message, $cancelReason];


        $query .= " WHERE order_id = ?";
        $params[] = $order_id;

        $update = $db->query($query, $params);
        $affectedRows = $db->affectedRows();

        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);
    }

    public function updateDeliveryStatus()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getPost();


        $order_id = $this->request->getPost('order_id');
        $delivery_status = $this->request->getPost('delivery_status');



        $query = "UPDATE tbl_orders SET 
                    delivery_status = ?, 
                    delivery_message = ?";


        $params = [$delivery_status, $delivery_status];


        if ($delivery_status == 2) {
            $query .= ", order_date = NOW()";
        } elseif ($delivery_status == 3) {
            $query .= ", process_date = NOW()";
        } elseif ($delivery_status == 4) {
            $query .= ", shipped_date = NOW()";
        } elseif ($delivery_status == 5) {
            $query .= ", delivery_date = NOW()";
        }


        $query .= " WHERE order_id = ?";
        $params[] = $order_id;

        $update = $db->query($query, $params);
        $affectedRows = $db->affectedRows();

        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);
    }

    public function filterOrders()
    {
        $db = \Config\Database::connect();
        $filterDate = $this->request->getPost("filter_date");

        $query = "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND b.flag = 1 AND DATE(a.log)  = ?";

        $result = $db->query($query, [$filterDate])->getResultArray();
        echo json_encode($result);
    }

    public function checkPayment()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("orderID");

        $qry = "SELECT  `razerpay_payment_id`, `razerpay_order_id` ,`razerpay_signature` FROM `tbl_orders` WHERE flag = 1 
                AND order_id = ?";
        $orderDetails = $db->query($qry, [$orderID])->getResultArray();
        $razorpay_order_id = $orderDetails[0]['razerpay_order_id'];
        $razorpay_payment_id = $orderDetails[0]['razerpay_payment_id'];

        $key_id = $_ENV['RAZORPAY_KEY_ID'];
        $secret = $_ENV['RAZORPAY_KEY_SECRET'];

        $api = new Api($_ENV['RAZORPAY_KEY_ID'], $secret);
        $payment = $api->payment->fetch($razorpay_payment_id);


        $paymentStatus = $payment->status;
        $method = $payment->method;

        if ($paymentStatus === "captured") {

            $deliveryMsg = 1;
            $deliveryStatus = 1;
            $payment_status = 2;
            $orderstatus = "success";

            $orderQry = "UPDATE tbl_orders SET order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
            $updateData = $db->query($orderQry, [$orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $method, $orderID]);

            $affectedRows = $db->affectedRows();
            if ($affectedRows === 1) {
                $res['code'] = 200;
                $res['status'] = "success";
                $res['msg'] = "Payment Success";
            } else {
                $res['code'] = 400;
                $res['status'] = "failure";
                $res['msg'] = "Payment Failure";
            }
            echo json_encode($res);
        } else if ($paymentStatus === "pending") {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Paymet Pending";
        }

    }

    public function pdfViewpage($segment)
    {

        $db = \Config\Database::connect();
        $orderID = base64_decode($segment);



        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();

        $data = [];

        for ($i = 0; $i < count($itemDetails); $i++) {

            $prodID = $itemDetails[$i]['prod_id'];
            $tableName = $itemDetails[$i]['table_name'];
            $color = $itemDetails[$i]['color'];
            $hexCode = $itemDetails[$i]['hex_code'];
            $size = $itemDetails[$i]['size'];

            $itemQuery = "SELECT a.order_id,a.order_no,a.sub_total,a.courier_charge,a.order_status,a.log as order_time,a.order_date,a.razerpay_payment_id,
            a.payment_status,a.delivery_status,a.cancel_reason,a.courier_type,
            b.`quantity`, b.`prod_price`, b.`sub_total` AS product_price, 
            b.color,b.hex_code,b.size,b.config_image1,b.color_name,b.color_name,c.product_name, c.product_price AS actual_price,c.offer_price,c.offer_type,c.offer_details,
            c.product_img, c.stock_status, d.*,e.state_title ,f.dist_name,g.number,g.username,g.email
                        FROM tbl_orders AS a 
                        LEFT JOIN tbl_order_item AS b ON a.order_id = b.order_id 
                        INNER JOIN $tableName AS c ON b.prod_id = c.prod_id
                        INNER JOIN tbl_user_address AS d ON a.add_id = d.add_id
                        INNER JOIN tbl_state AS e ON e.state_id = d.state_id
                        INNER JOIN tbl_district  AS f  ON f.dist_id = d.dist_id
                        INNER JOIN tbl_users AS g ON g.user_id = d.user_id
                        WHERE d.default_addr = 1 AND d.flag = 1 
                          AND b.order_id = ? AND c.prod_id = ? AND c.flag = 1 AND a.flag = 1 AND b.color =? AND
                        b.hex_code =? AND b.size = ?";


            $itemRes = $db->query($itemQuery, [$orderID, $prodID, $color, $hexCode, $size])->getRowArray();

            if ($itemRes) {
                $data[] = $itemRes;
            }

        }


        $orderSummaries[$orderID] = $data;

        $res['data'] = $orderSummaries[$orderID];
        ob_start();
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $html = view('orderPDF', $res);
        $dompdf->loadHtml($html);
        $dompdf->render();

        // Clear output buffer
        ob_clean();

        header("Cache-Control: maxage=1");
        header("Pragma: public");
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=order_$orderID.pdf");
        header("Content-Description: OrderList Data");
        header("Content-Transfer-Encoding: binary");

        // Clear output buffer again and flush
        ob_clean();
        flush();
        $output = $dompdf->output();

        // file_put_contents("./pdfs/order_$orderID.pdf", $output);
        echo $output;
        exit;



    }

    public function printPdf($orderID)
    {

        $data['pdfUrl'] = base_url() . "/pdfs/order_$orderID.pdf";

        return view('admin/print_pdf', $data);
    }


    public function processRefund()
    {

        $db = \Config\Database::connect();
        $getData = $this->request->getPost();


        $payment_id = $this->request->getPost('payment_id');
        $order_id = $this->request->getPost('order_id');
        $amount_type = $this->request->getPost('amount_type');



        $query = "SELECT `sub_total`,`courier_charge`  FROM `tbl_orders` WHERE flag =1 AND `order_id` =  ?";
        $getData = $db->query($query, [$order_id])->getRow();


        $ToalAmt = $getData->sub_total;
        $courierCharge = $getData->courier_charge;


        $total = (int) $ToalAmt;
        $courier = (int) $courierCharge;


        if ($amount_type == 0) {
            $RefundAmt = $total - $courier;
        } else if ($amount_type == 1) {
            $RefundAmt = $total;
        }

        $refund = (int) ($RefundAmt);




        if ($refund > $total) {


            return json_encode([
                'error' => [
                    'code' => 'BAD_REQUEST_ERROR',
                    'description' => 'The total refund amount is greater than the refund payment amount',
                    'source' => 'NA'
                ]
            ]);
        } else {

            $data = [
                'amount' => $RefundAmt * 100
            ];

            $url = "https://api.razorpay.com/v1/payments/" . $payment_id . "/refund";

            $api_key = $_ENV['RAZORPAY_KEY_ID'];
            $api_secret = $_ENV['RAZORPAY_KEY_SECRET'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            } else {
                $response_data = json_decode($response, true);


                if (isset($response_data['id']) && in_array($response_data['status'], ['created', 'processed'])) {
                    $deliveryStatus = ($response_data['status'] == 'created') ? 7 : 8;
                    $deliveryMessage = $deliveryStatus;
                    $refundID = $response_data['id'];
                    $refundAmt = $response_data['amount'];

                    $totalRefund = $refundAmt / 100;



                    $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ?, `refund_id` = ?,`refund_amt` = ? WHERE order_id = ?";
                    $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $refundID, $totalRefund, $order_id]);

                    if ($db->affectedRows() == 1) {
                        $res['code'] = 200;
                        $res['message'] = 'Refund is' . $response_data['status'];
                        $res['status'] = 'success';
                    }
                    echo json_encode($res);
                } elseif (isset($response_data['id']) && $response_data['status'] == 'failed') {
                    // Handle failed refunds
                    $deliveryStatus = 9;
                    $deliveryMessage = 9;
                    $refundID = $response_data['id'];
                    $refundAmt = $response_data['amount'];

                    $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ?, `refund_id` = ?, `refund_amt` = ? WHERE order_id = ?";
                    $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $refundID, $refundAmt / 100, $order_id]);

                    if ($db->affectedRows() == 1) {
                        $res['code'] = 400;
                        $res['message'] = 'Refund Failed';
                        $res['status'] = 'error';
                    }
                    echo json_encode($res);
                } else {

                    $res['code'] = 400;
                    $res['message'] = "Refund failed: " . $response_data['error']['description'];
                    $res['status'] = 'failure';
                    echo json_encode($res);
                }

            }
            curl_close($ch);

        }
    }


    public function checkRefundStatus()
    {
        $db = \Config\Database::connect();

        $orderID = $this->request->getPost('order_id');


        $query = "SELECT `refund_id`  FROM `tbl_orders` WHERE `order_id` = ?";
        $getRefund = $db->query($query, [$orderID])->getRow();


        $refundID = $getRefund->refund_id;

        try {

            $refund = $this->api->refund->fetch($refundID);

            if ($refund) {
                $refundStatus = $refund['status'];

                if ($refundStatus == 'processed') {
                    $deliveryStatus = 8;
                    $deliveryMessage = 8;
                } else if ($refundStatus == 'failed') {
                    $deliveryStatus = 9;
                    $deliveryMessage = 9;
                } else if ($refundStatus == 'created') {
                    $deliveryStatus = 7;
                    $deliveryMessage = 7;
                }

                $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ? WHERE order_id = ? AND `refund_id` = ?";
                $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $orderID, $refundID]);

                $affectedRows = $db->affectedRows();

                if ($affectedRows == 1) {
                    $res['code'] = 200;
                    $res['message'] = 'Updated Successfully';
                    $res['status'] = 'success';
                } else {
                    $res['code'] = 400;
                    $res['message'] = 'Updated Failed';
                    $res['status'] = 'failure';
                }

            }

            return json_encode($res);
        } catch (\Exception $e) {
            $res['code'] = 400;
            $res['message'] = $e->getMessage();
            $res['status'] = 'failure';
            return json_encode($res);
        }



    }

}