import { Link } from "react-router";
import useCartContext from "../../../../contexts/cart/useCartContext";
import CheckoutCartItem from "./CheckoutCartItem";
import YourCartSkeleton from "./YourCartSkeleton";

const YourCart = () => {
  const { cart, isCartLoading } = useCartContext();

  if (isCartLoading) {
    return <YourCartSkeleton />;
  }

  return (
    <div className="flex-1 p-4 py-6 md:p-6 bg-light">
      <div className="mb-2 flex items-center justify-between">
        <h4 className="text-xl font-bold">Your Cart</h4>
        {/* Link to edit the cart */}
        <Link
          to={"/cart"}
          className="text-primary underline underline-offset-1 font-semibold"
        >
          Edit
        </Link>
      </div>

      <div className="divide-y">
        {cart.map((item) => (
          <CheckoutCartItem key={item.id} cartItem={item} />
        ))}
      </div>
    </div>
  );
};

export default YourCart;
