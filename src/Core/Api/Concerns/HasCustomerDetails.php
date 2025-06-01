<?php

namespace Bensondevs\Midtrans\Core\Api\Concerns;

trait HasCustomerDetails
{
    public function setCustomerDetails(array $customerDetails): static
    {
        $this->customerDetails = $customerDetails;

        return $this;
    }

    public function getCustomerDetails(): array
    {
        $details = $this->customerDetails;

        return [
            'first_name' => $details['first_name'] ?? '',
            'last_name' => $details['last_name'] ?? $details['first_name'] ?? '',
            'email' => $details['email'] ?? '',
            'phone' => $details['phone'] ?? '',
        ];
    }
}
