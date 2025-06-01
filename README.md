# Laravel Midtrans

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bensondevs/laravel-midtrans.svg?style=flat-square)](https://packagist.org/packages/bensondevs/laravel-midtrans)
[![Total Downloads](https://img.shields.io/packagist/dt/bensondevs/laravel-midtrans.svg?style=flat-square)](https://packagist.org/packages/bensondevs/laravel-midtrans)

A modern, testable, and fluent Laravel wrapper for the [Midtrans](https://midtrans.com) API.

Supports:
- Snap payments
- Subscription billing
- Card registration
- GoPay partner account creation
- Laravel auto-discovery and configuration publishing

---

## 🚧 Project Status
This package is currently in alpha testing phase.

The development process has encountered several challenges, particularly with GoPay-related integration, due to inconsistencies and gaps in the official Midtrans documentation. Please expect some rough edges, especially around GoPay functionality.

Your feedback and contributions are highly appreciated as the package stabilizes.

---

## 🔧 Installation

You can install the package via Composer:

```bash
composer require bensondevs/laravel-midtrans
```

If you want to publish the config file:

```bash
php artisan vendor:publish --tag=midtrans-config
```

---

## ⚙️ Configuration

After publishing, configure your `.env`:

```dotenv
MIDTRANS_SANDBOX=true
MIDTRANS_SANDBOX_CLIENT_KEY=your_sandbox_client_key
MIDTRANS_SANDBOX_SERVER_KEY=your_sandbox_server_key

MIDTRANS_PRODUCTION_CLIENT_KEY=your_production_client_key
MIDTRANS_PRODUCTION_SERVER_KEY=your_production_server_key
```

---

## 💳 Billable Trait

To make a model (like `User`) billable, use the `Billable` trait:

```php
use Bensondevs\Midtrans\Models\Concerns\Billable;

class User extends Authenticatable
{
    use Billable;
}
```

This trait provides:

- `snapCharge(array $order)`
- `refund(TransactionDetails $order, ?int $amount = null, ?string $reason = '')`
- `subscribe(Subscribable $subscribable, PaymentType|string $paymentType, string $token)`
- `gopaySubscribe(Subscribable $subscribable, GopayPaymentOption|string|null $paymentOption)`
- `registerCard(...)` via `HasRegisteredCards`
- `createGopayAccount()` and `getGopayToken(...)` via `HasGopayAccounts`

Ensure your model implements `Customer`, and optionally `Subscribable` or `TransactionDetails`.

---

## 🚀 Usage Examples

### Snap Payment

```php
$response = $user->snapCharge([
    'order_id' => now()->timestamp,
    'gross_amount' => 100000,
]);

$redirectUrl = $response->getRedirectUrl();
```

### Refund

```php
$user->refund($order, 50000, 'Customer requested refund');
```

### Create Subscription (Credit Card)

```php
$user->subscribe($plan, PaymentType::CreditCard, $cardToken);
```

### Create Subscription (GoPay)

```php
$user->gopaySubscribe($plan);
```

### Register Credit Card

```php
$user->registerCard('4811111111111114', '12', '2025');
```

### Create GoPay Partner Account

```php
$activationUrl = $user->getGopayActivationUrl('https://yourapp.com/redirect');
```

---

## ✅ Testing

```bash
composer test
```

Make sure to set valid sandbox credentials in your `.env`.

---

## 📦 Roadmap

- [x] Snap charge
- [x] Subscription API
- [x] Card registration
- [x] GoPay partner creation
- [ ] Refunds & Transaction status
- [ ] Event handling (webhooks)

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to open an issue or submit a pull request.

---

## 📄 License

MIT © [Simeon Benson](https://github.com/bensondevs)
