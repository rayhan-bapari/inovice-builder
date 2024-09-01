<?php
class Invoice
{
    private $invoice_id;
    private $order_id;
    private $client_details;
    private $items = [];
    private $discount = 0;
    private $tax = 0;
    private $subtotal = 0;
    private $total_price = 0;

    public function __construct($invoice_id, $order_id, $items = [], $discount = 0, $tax = 0, $subtotal = 0, $total_price = 0)
    {
        $this->invoice_id = $invoice_id;
        $this->order_id = $order_id;
        $this->items = $items;
        $this->discount = $discount;
        $this->tax = $tax;
        $this->subtotal = $subtotal;
        $this->total_price = $total_price;
    }

    public function setClientDetails($client_details)
    {
        $this->client_details = $client_details;
    }

    public function addItem($name, $quantity, $price)
    {
        $this->items[] = [
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price
        ];
        $this->subtotal += $quantity * $price;
        $this->calculateTotalPrice();
    }

    public function addTax($tax)
    {
        $this->tax = $tax;
        $this->calculateTotalPrice();
    }

    public function applyDiscount($discount)
    {
        $this->discount = $discount;
        $this->calculateTotalPrice();
    }

    private function calculateTotalPrice()
    {
        $this->total_price = $this->subtotal + ($this->subtotal * $this->tax / 100) - $this->discount;
    }

    public function generateInvoice()
    {
        $invoice = '
        <div class="container">
            <div class="row flex-column">
                <div class="pt-5">
                    <p>Store Name</p>
                </div>
                <address>
                    Street City, State 000<br />
                    Tel: 01000000000<br />
                    Mail: store@store.com
                </address>
                <p class="invoice-title">Order</p>
            </div>
            <div class="container order-info">
                <span>Invoice Id: ' . $this->invoice_id . '</span>
                <span>Order No.: ' . $this->order_id . '</span><br>
            </div>
            <div>
                <p>Client Name: ' . $this->client_details . '</p>
                <span>Date: ' . date('Y-m-d') . '</span>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <table class="table table-borderless table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($this->items as $item) {
            $subtotal = $item['quantity'] * $item['price'];
            $invoice .= '
                    <tr>
                        <td>' . $item['name'] . '</td>
                        <td>' . $item['quantity'] . '</td>
                        <td>' . $item['price'] . '</td>
                        <td>' . $subtotal . '</td>
                    </tr>';
        }

        $invoice .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Discount:</td>
                        <td>' . $this->discount . '%</td>
                    </tr>
                    <tr>
                        <td colspan="3">Tax:</td>
                        <td>' . $this->tax . '%</td>
                    </tr>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td>' . $this->total_price . '</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <footer>
                <p>Thank you</p>
                <p>
                    Returns within 14 days and purchases within 24 hours of the original
                    invoice, and the products must be in their original condition.
                </p>
                <div>
                    <span>' . date("m/d/Y H:i:s") . '</span>
                </div>
            </footer>
        </div>
    </div>';

        return $invoice;
    }
}
