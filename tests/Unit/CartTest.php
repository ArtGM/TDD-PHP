<?php

test('should price a cart according to its items', function (
    array $orderLines,
    int   $expectedTotalWithDiscount
) {
    expectCartPrice($orderLines, $expectedTotalWithDiscount);
})->with(
    [
        "empty cart" => [[], 0],
        "one unit for one item in the cart" => [[
            new OrderLine("raquette", 1, 200)
        ], 200],
        "two units for a same item in the cart" => [[
            new OrderLine("raquette", 2, 200)
        ], 400],
        "two distinct units in the cart" => [[
            new OrderLine("raquette", 1, 200),
            new OrderLine("piano", 1, 1000)
        ], 1200],
    ]
);

test('should apply a discount (1 item occurrence free) when more than 10 occurrences are ordered', function () {
    $orderLines[] = new OrderLine("jouet", 1, 1);
    $orderLines[] = new OrderLine("raquette", 11, 200);
    expectCartPrice($orderLines, 2001);
});

    function expectCartPrice(array $orderLines, int $expectedTotalWithDiscount): void
    {
        expect((new Cart(new DiscountApplicator()))->calculateTotal($orderLines))->toBe($expectedTotalWithDiscount);
    }

    class OrderLine
    {
        public function __construct(
            public string $product,
            public int    $quantity,
            public int    $unitPrice
        )
        {
        }
    }

    class Cart
    {


        public function __construct(private readonly DiscountApplicator $discountApplicator)
        {
        }

        public function calculateTotal(array $orderLines): int
        {
            return array_reduce($orderLines, fn($total, $orderLine) =>
                $total + $this->priceCurrentItem($orderLine), 0);
        }

        private function priceCurrentItem(OrderLine $orderLine): int
        {
            return ($this->isDiscountApplicable($orderLine) ?
                $this->discountApplicator->applyDiscount($orderLine) :
                $orderLine->quantity * $orderLine->unitPrice);
        }

        private function isDiscountApplicable(OrderLine $orderLine): bool
        {
            return $orderLine->quantity >= 10;
        }
    }

    class DiscountApplicator
    {
        public function applyDiscount(OrderLine $orderLine): int
        {
            return ($orderLine->quantity - 1) * $orderLine->unitPrice;
        }
    }
