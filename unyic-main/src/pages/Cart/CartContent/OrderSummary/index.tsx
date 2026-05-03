import Button from "../../../../components/ui/Button";
import useCartContext from "../../../../contexts/cart/useCartContext";

const OrderSummary = () => {
  const { cart, cartTotal } = useCartContext();

  return (
    <div
      id="order-summary"
      className="h-max p-3 bg-light scroll-mt-20"
    >
      <div className="h-35 space-y-3">
        <div className="flex items-center justify-between">
          <p className="font-semibold">Order Summary</p>
          <p className="text-dark-light text-sm self-end">
            {cart.length} items
          </p>
        </div>

        <div className="flex items-center justify-between text-sm">
          <p className="text-dark-light">Order Value</p>
          <p className="font-semibold">₹ {cartTotal}</p>
        </div>

        <div className="flex items-center justify-between text-sm">
          <p className="text-dark-light">Shipping Charges</p>
          <p className="uppercase font-semibold">Free</p>
        </div>

        <hr />

        <div className="flex items-center justify-between">
          <p className="font-semibold text-dark-light">Grand Total</p>
          <p className="font-semibold">₹ {cartTotal + 0}</p>
        </div>
      </div>

      {/* Show only in larger screen */}
      <Button href="/checkout" className="hidden sm:block mt-4 uppercase">
        Checkout
      </Button>
    </div>
  );
};

export default OrderSummary;
