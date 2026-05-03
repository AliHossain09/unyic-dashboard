import Button from "../../../../components/ui/Button";
import useCartContext from "../../../../contexts/cart/useCartContext";

const OrderSummary = () => {
  const { cartTotal, cart } = useCartContext();

  return (
    <div className="flex-1 p-4 py-6 md:p-6 bg-light">
      <div className="flex justify-between gap-3">
        <h4 className="mb-4 text-lg font-bold">Order Summary</h4>

        <p className="mt-1 md:mt-0.50 text-dark-light text-sm">
          {cart.length} {cart.length === 1 ? "item" : "items"}
        </p>
      </div>

      {/* Order value display */}
      <div className="mb-3 flex items-center justify-between">
        <p className="text-dark">Order Value</p>
        <p className="font-semibold">₹ {cartTotal}</p>
      </div>

      {/* Shipping charges display */}
      <div className="mb-3 flex items-center justify-between">
        <p className="text-dark">Shipping Charges</p>
        <p className="uppercase font-semibold text-sm">Free</p>
      </div>

      <hr />

      {/* Grand total display */}
      <div className="mt-4 mb-8 flex items-center justify-between font-semibold">
        <p>Grand Total</p>
        <p>₹ {cartTotal + 0}</p>
      </div>

      {/* Place Order Button */}
      <Button form="delivery-info-form" type="submit" className="uppercase">
        Place Order
      </Button>
    </div>
  );
};

export default OrderSummary;
