import { Link } from "react-router";
import Button from "../../../components/ui/Button";
import useCartContext from "../../../contexts/cart/useCartContext";

const OrderSummary = () => {
  const { cartTotal } = useCartContext();

  return (
    <div className="flex-1 space-y-4 p-4 md:p-6 bg-light">
      <div className="flex items-center justify-between">
        <h4 className="font-semibold">Order Summary</h4>
        {/* Link to edit the cart */}
        <Link
          to={"/cart"}
          className="text-primary underline underline-offset-1 text-sm"
        >
          Edit Cart
        </Link>
      </div>

      {/* Order value display */}
      <div className="flex items-center justify-between text-sm">
        <p className="text-dark">Order Value</p>
        <p className="font-semibold">₹ {cartTotal}</p>
      </div>

      {/* Shipping charges display */}
      <div className="flex items-center justify-between text-sm">
        <p className="text-dark">Shipping Charges</p>
        <p className="uppercase font-semibold">Free</p>
      </div>

      <hr />

      {/* Grand total display */}
      <div className="flex items-center justify-between !mb-5 font-semibold">
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
