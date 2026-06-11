<?php

namespace Tests\Unit\Enums;

use Tests\TestCase;
use App\Enums\OrderStatus;
use Filament\Support\Contracts\HasLabel;

class OrderStatusTest extends TestCase
{
    public function test_enum_has_all_cases(): void
    {
        $cases = OrderStatus::cases();

        $this->assertCount(6, $cases);
        $this->assertContains(OrderStatus::PENDING, $cases);
        $this->assertContains(OrderStatus::WAITING_FOR_CONFIRMATION, $cases);
        $this->assertContains(OrderStatus::PREPARATION, $cases);
        $this->assertContains(OrderStatus::CANCELED, $cases);
        $this->assertContains(OrderStatus::SERVING, $cases);
        $this->assertContains(OrderStatus::PAID, $cases);
    }

    public function test_enum_values_are_persian_strings(): void
    {
        $this->assertEquals('در حال پردازش', OrderStatus::PENDING->value);
        $this->assertEquals('منتظر تایید', OrderStatus::WAITING_FOR_CONFIRMATION->value);
        $this->assertEquals('در حال آماده سازی', OrderStatus::PREPARATION->value);
        $this->assertEquals('انصراف', OrderStatus::CANCELED->value);
        $this->assertEquals('در حال سرو', OrderStatus::SERVING->value);
        $this->assertEquals('پرداخت شده', OrderStatus::PAID->value);
    }

    public function test_implements_has_label(): void
    {
        $this->assertInstanceOf(HasLabel::class, OrderStatus::PENDING);
    }

    public function test_get_label_returns_value(): void
    {
        $this->assertEquals(OrderStatus::PENDING->value, OrderStatus::PENDING->getLabel());
        $this->assertEquals(OrderStatus::PAID->value, OrderStatus::PAID->getLabel());
    }

    public function test_enum_is_backed_by_string(): void
    {
        $this->assertEquals('string', gettype(OrderStatus::PENDING->value));
        $this->assertEquals('string', gettype(OrderStatus::PAID->value));
    }
}
