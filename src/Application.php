<?php

namespace App;

use App\Cart\Item;
use App\Cart\ShoppingCart;
use App\Order\Order;
use App\Invoice\TextInvoice;
use App\Invoice\PDFInvoice;
use App\Customer\Customer;
use App\Payments\CashOnDelivery;
use App\Payments\CreditCardPayment;
use App\Payments\PaypalPayment;

class Application
{
    public static function run()
    {
        $ps5 = new Item('PS5', 'Play Station 5' , 25000);
        $console = new Item('CL1', 'Console for Gaming' , 1000);

        $shopping_cart = new ShoppingCart();
        $shopping_cart->addItem($ps5, 5);
        $shopping_cart->addItem($console, 2);
        $customer = new Customer('Calvin Kent Pamandanan', 'Mexico Pampanga', 'pamandanan.calvin@auf.edu.ph');
        $order = new Order($customer, $shopping_cart);

        $invoice = new PDFInvoice();
        $order->setInvoiceGenerator($invoice);
        $invoice->generate($order);

        $payment = new PaypalPayment('calvin.paypal@gmail.com', 'calvinpassword');
        $order->setPaymentMethod($payment);
        $order->payInvoice();
    }
}