<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Invoice;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order)
    {
        //
    }

    public function viaQueues() : array
    {
        return [
            'mail' => 'admin-mail',
            'telegram' => 'admin-telegram',
        ];
    }

    public function via(User $user): array
    {
        return ['mail'];
    }

    public function toMail(User $user): MailMessage
    {
        $invoice = $this->invoicePDF($this->order);
        $invoiceContent = file_get_contents($invoice);

        logs()->info('notify admin by email!', ['FilePath:' => $invoice]);

        return (new MailMessage)
            ->subject('Your Order and Invoice')
            ->greeting('Hello ' . $this->order->name . ',')
            ->line('Thank you for your recent order. We are pleased to inform you that your order has been processed successfully.')
            ->line('Attached to this email, you will find the invoice for your purchase. Please review the invoice for the details of the items you ordered and the total amount due.')
            ->line('If you have any questions or need further assistance, please do not hesitate to contact our support team.')
            ->line('Thank you for shopping with us!')
            ->attachData($invoiceContent, 'Order Details.pdf', ['mime' => 'application/pdf']);
    }

    protected function invoicePDF(Order $order): string
    {
        $invoiceService = new InvoiceService();
        $invoiceDoc = $invoiceService->generate($order);
        return Storage::path($invoiceDoc->filename);
    }

}
